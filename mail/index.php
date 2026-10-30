<?php
require __DIR__ . '/../inc/layout.php';
require __DIR__ . '/../inc/prices.php';
site_head('Chelkron Mail', 'Professional email on your own domain. Webmail on any device, works with Outlook and your phone, set up to stay out of spam. Free for 14 days.', '/mail', ['body_class' => 'p-mail']); ?>

<section class="phero">
    <div class="wrap phero-in">
        <div>
            <p class="eyebrow"><img src="/assets/mail-icon.svg" alt="" width="28" height="28">Chelkron Mail</p>
            <h1>Look like the big company you're becoming.</h1>
            <p class="lead"><i>hello@yourbusiness.com</i> wins deals that <i>yourbusiness234@gmail.com</i> never will. Chelkron Mail puts your name on every email your team sends.</p>
            <div class="hero-cta">
                <a class="btn btn-blue" href="https://mail.chelkron.com/signup">Start 14 days free</a>
                <a class="btn btn-ghost btn-lg" href="#plans">See plans</a>
            </div>
            <p class="phero-note">Five professional mailboxes from <?= site_naira(site_yearly(SITE_PLANS['mail']['plans'][0]['price'])[0]) ?> a month, paid yearly.</p>
        </div>
        <?php require __DIR__ . '/../inc/parts/shot-mail.php'; ?>
    </div>
</section>

<section class="features" aria-labelledby="feat-h">
    <div class="wrap">
        <h2 id="feat-h" class="sec-h">Email that works as hard as you do</h2>
        <div class="fgrid">
            <div class="fcard"><h3>Your domain, in minutes</h3><p>Search, buy and connect a domain without leaving the app, or bring the one you already own. Every staff member gets their own address. <a href="https://domains.chelkron.com/">Find a domain</a></p></div>
            <div class="fcard"><h3>Straight to the inbox</h3><p>We set up SPF, DKIM and DMARC with you, step by step: the behind-the-scenes checks that keep your emails out of spam.</p></div>
            <div class="fcard"><h3>The Mailbox</h3><p>Fast, clean webmail on any device. Several mailboxes side by side, instant new-mail alerts, and an app on your home screen. In four languages.</p></div>
            <div class="fcard"><h3>Keep the apps you love</h3><p>Outlook, Apple Mail or your phone's own mail app: they all work with Chelkron Mail.</p></div>
            <div class="fcard"><h3>Write it in seconds</h3><p>AI Compose drafts a clear, polite email for you. You check it, you send it.</p></div>
            <div class="fcard"><h3>Locked tight</h3><p>New phone or laptop? It needs a one-time code before it gets in.</p></div>
        </div>
    </div>
</section>

<section class="plans-sec" id="plans" aria-labelledby="plans-h">
    <div class="wrap">
        <h2 id="plans-h" class="sec-h">Plans for every team size</h2>
        <p class="sec-p">Every plan starts with 14 days free. Pay monthly, or pay yearly and keep <?= SITE_YEARLY_OFF ?>%. Domain registration is billed separately.</p>
        <?php site_plan_cards('mail'); ?>
        <div class="callout">
            <h3>Already on Chelkron Workforce?</h3>
            <p>Workforce Starter, Growth and Enterprise include Chelkron Mail Starter free for up to 12 months. Find your code on your Workforce Billing page. <a href="/pricing#bundle">How it works</a></p>
        </div>
    </div>
</section>

<?php site_foot(); ?>
