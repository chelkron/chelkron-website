<?php
/**
 * support.chelkron.com — support request form handler.
 * Emails the request to support with a reference number (CK-YYMMDD-XXXX) in the subject, so replies stay in one thread.
 * Answers JSON to the page, or redirects back to it when JavaScript is off.
 * Spam guards: a hidden field people never fill, a minimum time filling in the form, and a limit per IP address.
 */
const TO        = 'support@chelkron.com';
const FROM      = 'noreply@chelkron.com';   // must be an address on this domain for the mail to be delivered
const PER_HOUR  = 5;                        // requests per IP address per hour

$json = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
function done(bool $ok, string $msg, bool $json, string $ref = ''): void {
    if ($json) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($ok ? 200 : 400);
        echo json_encode(['ok' => $ok, 'message' => $msg, 'ref' => $ref]);
    } else {
        header('Location: /?' . ($ok ? 'sent=' . rawurlencode($ref ?: 'received') : 'error=' . rawurlencode($msg)) . '#request');
    }
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { header('Location: /#request'); exit; }

$clean   = fn($v, $max) => mb_substr(trim(str_replace(["\r", "\n", "\0"], ' ', (string)$v)), 0, $max);
$pick    = fn($v, array $ok) => in_array($v, $ok, true) ? $v : end($ok);
$name    = $clean($_POST['name'] ?? '', 100);
$email   = $clean($_POST['email'] ?? '', 150);
$account = $clean($_POST['account'] ?? '', 200);
$product = $pick($_POST['product'] ?? '', ['Chelkron Workforce', 'Chelkron Mail', 'Something else']);
$topic   = $pick($_POST['topic'] ?? '', ['Something isn\'t working', 'Payments and billing', 'Signing in and my account', 'Setting up', 'A question']);
$message = mb_substr(trim(str_replace("\0", '', (string)($_POST['message'] ?? ''))), 0, 5000);

// Bots: the hidden "website" field is filled, or the form was sent within 3 seconds of starting it
// (t = milliseconds, measured in the browser; 0 when JavaScript is off). Pretend it worked.
$fill_ms = (int)($_POST['t'] ?? 0);
if (($_POST['website'] ?? '') !== '' || ($fill_ms > 0 && $fill_ms < 3000)) done(true, "Thanks — we've received your request. We'll reply by email.", $json);

if ($name === '' || $message === '') done(false, 'Please fill in your name and describe the problem.', $json);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) done(false, 'Please enter a valid email address so we can reply.', $json);
if (mb_strlen($message) < 10) done(false, 'Please tell us a little more about the problem.', $json);

// Limit per IP address (kept in the server's temp folder)
$ip   = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$file = sys_get_temp_dir() . '/chelkron_support_' . md5($ip);
$hits = array_filter((array)json_decode((string)@file_get_contents($file), true), fn($t) => is_int($t) && $t > time() - 3600);
if (count($hits) >= PER_HOUR) done(false, 'You have sent several requests already. Please try again later, or message us on WhatsApp.', $json);

$ref  = 'CK-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
$body = "Reference: $ref\nName: $name\nEmail: $email\nProduct: $product\nAbout: $topic\n"
      . ($account !== '' ? "Workspace / account: $account\n" : '')
      . "\n$message\n\n— Sent from support.chelkron.com\nIP: $ip";
$headers = [
    'From: Chelkron Support form <' . FROM . '>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: support.chelkron.com',
];
$short   = $product === 'Something else' ? '' : ' ' . str_replace('Chelkron ', '', $product);
// Plain-text subjects stay as they are; anything else is encoded in short pieces that every mail program can read
// (one long encoded piece over 75 characters shows up as =?UTF-8?B?…?= in some inboxes).
function mail_subject(string $s): string {
    return preg_match('/^[\x20-\x7E]*$/', $s) ? $s : mb_encode_mimeheader($s, 'UTF-8', 'B', "\r\n");
}
$subject = mail_subject("[$ref]$short - $topic - $name");
$sent = @mail(TO, $subject, $body, implode("\r\n", $headers), '-f' . FROM);
if (!$sent) done(false, 'We could not send your request just now. Please try again, or use live chat or WhatsApp.', $json);

$hits[] = time();
@file_put_contents($file, json_encode(array_values($hits)), LOCK_EX);
done(true, "Your reference is $ref. We'll reply to $email.", $json, $ref);
