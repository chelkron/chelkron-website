<?php
/**
 * chelkron.com — "Send us a message" form handler.
 * Emails the message to support. Answers JSON to the pop-up form, or redirects back to the page when JavaScript is off.
 * Spam guards: a hidden field people never fill, a minimum time on the form, and a limit per IP address.
 */
const TO        = 'support@chelkron.com';
const FROM      = 'noreply@chelkron.com';   // must be an address on this domain for the mail to be delivered
const PER_HOUR  = 5;                        // messages per IP address per hour

$json = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
function done(bool $ok, string $msg, bool $json): void {
    if ($json) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($ok ? 200 : 400);
        echo json_encode(['ok' => $ok, 'message' => $msg]);
    } else {
        header('Location: /?' . ($ok ? 'sent=1' : 'error=' . rawurlencode($msg)) . '#contact');
    }
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') { header('Location: /#contact'); exit; }

$clean = fn($v, $max) => mb_substr(trim(str_replace(["\r", "\n", "\0"], ' ', (string)$v)), 0, $max);
$name    = $clean($_POST['name'] ?? '', 100);
$email   = $clean($_POST['email'] ?? '', 150);
$company = $clean($_POST['company'] ?? '', 120);
$topic   = in_array($_POST['topic'] ?? '', ['Chelkron Workforce', 'Chelkron Mail', 'Billing', 'Something else'], true) ? $_POST['topic'] : 'Something else';
$message = mb_substr(trim(str_replace("\0", '', (string)($_POST['message'] ?? ''))), 0, 5000);

// Bots: the hidden "website" field is filled, or the form was sent within 3 seconds of opening it
// (t = milliseconds the pop-up was open, measured in the browser; 0 when JavaScript is off). Pretend it worked.
$open_ms = (int)($_POST['t'] ?? 0);
if (($_POST['website'] ?? '') !== '' || ($open_ms > 0 && $open_ms < 3000)) done(true, 'Thanks — your message is on its way.', $json);

if ($name === '' || $message === '') done(false, 'Please fill in your name and your message.', $json);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) done(false, 'Please enter a valid email address so we can reply.', $json);
if (mb_strlen($message) < 10) done(false, 'Please tell us a little more in your message.', $json);

// Limit per IP address (kept in the server's temp folder)
$ip   = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$file = sys_get_temp_dir() . '/chelkron_contact_' . md5($ip);
$hits = array_filter((array)json_decode((string)@file_get_contents($file), true), fn($t) => is_int($t) && $t > time() - 3600);
if (count($hits) >= PER_HOUR) done(false, 'You have sent several messages already. Please try again later, or email ' . TO . '.', $json);

$body = "Name: $name\nEmail: $email\n" . ($company !== '' ? "Company: $company\n" : '') . "About: $topic\n\n$message\n\n— Sent from the contact form on chelkron.com\nIP: $ip";
$headers = [
    'From: Chelkron website <' . FROM . '>',
    'Reply-To: ' . $name . ' <' . $email . '>',
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: chelkron.com',
];
// Plain-text subjects stay as they are; anything else is encoded in short pieces that every mail program can read
// (one long encoded piece over 75 characters shows up as =?UTF-8?B?…?= in some inboxes).
function mail_subject(string $s): string {
    return preg_match('/^[\x20-\x7E]*$/', $s) ? $s : mb_encode_mimeheader($s, 'UTF-8', 'B', "\r\n");
}
$subject = mail_subject('[chelkron.com] ' . $topic . ' - ' . $name);
$sent = @mail(TO, $subject, $body, implode("\r\n", $headers), '-f' . FROM);
if (!$sent) done(false, 'We could not send your message just now. Please email ' . TO . ' instead.', $json);

$hits[] = time();
@file_put_contents($file, json_encode(array_values($hits)), LOCK_EX);
done(true, "Thanks — your message is on its way. We'll reply by email.", $json);
