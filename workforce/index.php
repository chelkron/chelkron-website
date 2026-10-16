<?php
require __DIR__ . '/../inc/layout.php';
require __DIR__ . '/../inc/prices.php';
site_head('Chelkron Workforce', 'CRM, HR, attendance, payroll, appraisals, tasks and team chat in one app, priced in your currency. Free for 14 days.', '/workforce', ['body_class' => 'p-workforce']); ?>

<section class="phero">
    <div class="wrap phero-in">
        <div>
            <p class="eyebrow"><img src="/assets/workforce-icon.svg" alt="" width="28" height="28">Chelkron Workforce</p>
            <h1>Your whole company. One app.</h1>
            <p class="lead">CRM, HR, payroll, appraisals, tasks and team chat in one place, set up in your words, your currency and your language.</p>
            <div class="hero-cta">
                <a class="btn btn-blue" href="https://workforce.chelkron.com/signup">Start 14 days free</a>
                <a class="btn btn-ghost btn-lg" href="#plans">See plans</a>
            </div>
            <p class="phero-note">From <?= site_naira(site_yearly(SITE_PLANS['workforce']['plans'][0]['price'])[0]) ?> a month, paid yearly. No card needed to try it.</p>
        </div>
        <?php require __DIR__ . '/../inc/parts/shot-workforce.php'; ?>
    </div>
</section>

<section class="features" aria-labelledby="feat-h">
    <div class="wrap">
        <h2 id="feat-h" class="sec-h">Everything your team runs on</h2>
        <div class="fgrid">
            <div class="fcard"><h3>Clock in. No excuses.</h3><p>Staff clock in from their phones. Workforce checks location, office Wi-Fi and the device they use, so "I'm on my way" stops counting as attendance. Remote staff? Switch the rules off for them.</p></div>
            <div class="fcard"><h3>Payday in minutes, not days</h3><p>Set salaries once. Workforce works out income tax and pension for Nigeria, Ghana, Kenya and South Africa, or any country with your own tax bands, and hands every staff member a clean payslip.</p></div>
            <div class="fcard"><h3>Every lead, followed up</h3><p>From first call to "payment received": every deal, every target, and who's chasing it. No more leads lost in someone's phone.</p></div>
            <div class="fcard"><h3>Your team, in sync</h3><p>Tasks with deadlines, a shared calendar, and team chat with voice notes, reactions and groups. Need a manager's eye? One tap raises an attention request.</p></div>
            <div class="fcard"><h3>Know who's delivering</h3><p>Reports that write themselves. Appraisals that are fair, consistent and on record.</p></div>
            <div class="fcard"><h3>Hand HR the keys, not the safe</h3><p>Let your HR or operations manager add and manage staff, while billing and salaries stay with you.</p></div>
            <div class="fcard"><h3>Lives on every phone</h3><p>Install it like an app. Get an alert the moment a task, meeting or message lands, and one tap takes you straight to it.</p></div>
            <div class="fcard"><h3>In your language</h3><p>English, French, Portuguese or Arabic, with right-to-left layouts for Arabic, so your whole team can use the same tools.</p></div>
        </div>
    </div>
</section>

<section class="plans-sec" id="plans" aria-labelledby="plans-h">
    <div class="wrap">
        <h2 id="plans-h" class="sec-h">Plans for 5 staff or 75</h2>
        <p class="sec-p">Every plan starts with 14 days free. Pay monthly, or pay yearly and keep <?= SITE_YEARLY_OFF ?>%.</p>
        <?php site_plan_cards('workforce'); ?>
        <div class="callout">
            <h3>Chelkron Mail, free for a year</h3>
            <p>On Starter, Growth or Enterprise, after 3 paid months we add Chelkron Mail Starter at no cost: 5 professional mailboxes on your own domain, free for up to 12 months while your Workforce plan stays active. Pay yearly and it's yours from day one. <a href="/pricing#bundle">How it works</a></p>
        </div>
    </div>
</section>

<?php site_foot(); ?>
