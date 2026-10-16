<?php
/**
 * chelkron.com — plans and prices shown on /pricing, /workforce and /mail.
 * Naira, monthly. The yearly price is 10% off (both apps' shared/cycle.php). Keep in step with the apps' billing pages.
 */
const SITE_YEARLY_OFF = 10;

const SITE_PLANS = [
    'workforce' => [
        'name' => 'Chelkron Workforce', 'signup' => 'https://workforce.chelkron.com/signup', 'unit' => 'staff',
        'plans' => [
            ['name' => 'Micro',      'price' => 6900,   'limit' => 'Up to 5 staff',  'points' => ['200 leads in the CRM', 'Attendance, leave, tasks and team chat', 'Payroll and payslips']],
            ['name' => 'Starter',    'price' => 14500,  'limit' => 'Up to 10 staff', 'points' => ['500 leads in the CRM', 'Everything in Micro', 'Free Chelkron Mail offer'], 'bundle' => true],
            ['name' => 'Growth',     'price' => 42000,  'limit' => 'Up to 30 staff', 'points' => ['Unlimited leads', 'Everything in Starter', 'Free Chelkron Mail offer'], 'bundle' => true, 'pick' => true],
            ['name' => 'Enterprise', 'price' => 129000, 'limit' => 'Up to 75 staff', 'points' => ['Unlimited leads', 'Your own custom domain', 'Priority support', 'Free Chelkron Mail offer'], 'bundle' => true],
        ],
        'more' => 'More than 75 staff?',
    ],
    'mail' => [
        'name' => 'Chelkron Mail', 'signup' => 'https://mail.chelkron.com/signup', 'unit' => 'mailboxes',
        'plans' => [
            ['name' => 'Starter',    'price' => 2900,  'limit' => 'Up to 5 mailboxes',  'points' => ['10 GB per mailbox', 'Your own domain', 'The Mailbox webmail app']],
            ['name' => 'Business',   'price' => 9500,  'limit' => 'Up to 20 mailboxes', 'points' => ['10 GB per mailbox', 'Everything in Starter', 'Aliases and catch-all'], 'pick' => true],
            ['name' => 'Enterprise', 'price' => 32000, 'limit' => 'Up to 50 mailboxes', 'points' => ['20 GB per mailbox', 'Everything in Business', 'Priority support']],
        ],
        'more' => 'More than 50 mailboxes?',
    ],
];

function site_naira(int $n): string { return '₦' . number_format($n); }
/** Per month when paid yearly, and the yearly total. */
function site_yearly(int $monthly): array {
    $pm = (int)round($monthly * (100 - SITE_YEARLY_OFF) / 100);
    return [$pm, $pm * 12];
}

/** The plan cards for one product. */
function site_plan_cards(string $product): void {
    $p = SITE_PLANS[$product]; ?>
<div class="plans plans-<?= count($p['plans']) ?> plans-<?= $product ?>">
<?php foreach ($p['plans'] as $pl) { [$pm, $yr] = site_yearly($pl['price']); ?>
    <div class="plan<?= !empty($pl['pick']) ? ' plan-pick' : '' ?>">
        <?php if (!empty($pl['pick'])): ?><span class="plan-badge">Recommended</span><?php endif; ?>
        <h3><?= site_e($pl['name']) ?></h3>
        <p class="plan-limit"><?= site_e($pl['limit']) ?></p>
        <p class="plan-price"><b><?= site_naira($pl['price']) ?></b><span>/month</span></p>
        <p class="plan-year"><b><?= site_naira($pm) ?>/month</b> paid yearly <span>(<?= site_naira($yr) ?> a year, save <?= SITE_YEARLY_OFF ?>%)</span></p>
        <ul><?php foreach ($pl['points'] as $pt) echo '<li>' . site_e($pt) . '</li>'; ?></ul>
        <a class="btn <?= !empty($pl['pick']) ? 'btn-blue' : 'btn-ghost' ?>" href="<?= site_e($p['signup']) ?>">Start 14 days free</a>
    </div>
<?php } ?>
</div>
<p class="plans-more"><?= site_e($p['more']) ?> Talk to us at <a href="mailto:business@chelkron.com">business@chelkron.com</a>.</p>
<?php
}
