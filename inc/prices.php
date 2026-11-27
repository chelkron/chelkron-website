<?php
/**
 * chelkron.com — plans and prices shown on /pricing, /packages, /workforce and /mail.
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
            ['name' => 'Starter',    'price' => 2900,  'limit' => 'Up to 5 mailboxes',  'points' => ['10 GB per mailbox', 'Your own domain', 'The Mailbox webmail app', 'Aliases and group addresses']],
            ['name' => 'Business',   'price' => 9500,  'limit' => 'Up to 20 mailboxes', 'points' => ['10 GB per mailbox', 'Everything in Starter', 'Catch-all address'], 'pick' => true],
            ['name' => 'Enterprise', 'price' => 32000, 'limit' => 'Up to 50 mailboxes', 'points' => ['20 GB per mailbox', 'Everything in Business', 'Priority support']],
        ],
        'more' => 'More than 50 mailboxes?',
    ],
];

/**
 * Chelkron packs: Sites + Mail + Workforce, one payment on Chelkron Sites (its lib/billing.php sites_packages()).
 * A year is 10 months' price there (2 months free). Keep in step with Sites.
 */
const SITE_PACKS = [
    'starter'  => ['name' => 'Starter pack',  'price' => 12500, 'normal' => 14800, 'for' => 'For a small business getting started',
                   'points' => ['Chelkron Sites Starter: your website with a shop', 'Chelkron Mail Starter: 5 mailboxes on your domain', 'Chelkron Workforce Micro: up to 5 staff']],
    'business' => ['name' => 'Business pack', 'price' => 27500, 'normal' => 34000, 'for' => 'For a growing team that sells online', 'pick' => true,
                   'points' => ['Chelkron Sites Business: 200 products, Paystack checkout', 'Chelkron Mail Business: 20 mailboxes, catch-all address', 'Chelkron Workforce Starter: up to 10 staff']],
    'pro'      => ['name' => 'Pro pack',      'price' => 75000, 'normal' => 94000, 'for' => 'For a busy company with a big team',
                   'points' => ['Chelkron Sites Store: unlimited products', 'Chelkron Mail Enterprise: 50 mailboxes, 20 GB each', 'Chelkron Workforce Growth: up to 30 staff']],
];
const SITE_PACK_URL = 'https://sites.chelkron.com/package?p=';

/** The pack cards. */
function site_pack_cards(): void { ?>
<div class="plans plans-3 plans-packs">
<?php foreach (SITE_PACKS as $key => $pk) { ?>
    <div class="plan<?= !empty($pk['pick']) ? ' plan-pick' : '' ?>">
        <?php if (!empty($pk['pick'])): ?><span class="plan-badge">Most popular</span><?php endif; ?>
        <h3><?= site_e($pk['name']) ?></h3>
        <p class="plan-limit"><?= site_e($pk['for']) ?></p>
        <p class="plan-price"><b><?= site_naira($pk['price']) ?></b><span>/month</span></p>
        <p class="plan-year"><s><?= site_naira($pk['normal']) ?></s> if bought separately: <b>save <?= site_naira($pk['normal'] - $pk['price']) ?> a month</b>
            <span>or <?= site_naira($pk['price'] * 10) ?> a year (2 months free)</span></p>
        <ul><?php foreach ($pk['points'] as $pt) echo '<li>' . site_e($pt) . '</li>'; ?><li>One payment, one renewal date</li></ul>
        <a class="btn <?= !empty($pk['pick']) ? 'btn-blue' : 'btn-ghost' ?>" href="<?= site_e(SITE_PACK_URL . $key) ?>">Get the <?= site_e($pk['name']) ?></a>
    </div>
<?php } ?>
</div>
<?php
}

/** A naira price (what Chelkron charges) shown in the visitor's currency (inc/currency.php). */
function site_naira(float $n): string { return site_money($n); }
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
