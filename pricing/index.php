<?php
require __DIR__ . '/../inc/layout.php';
require __DIR__ . '/../inc/prices.php';
site_head('Pricing', 'Plans and prices for Chelkron Workforce and Chelkron Mail. Every plan starts with 14 days free; pay yearly and keep 10%.', '/pricing'); ?>

<section class="page-head">
    <div class="wrap">
        <h1>Pay monthly. Or pay yearly and keep <?= SITE_YEARLY_OFF ?>%.</h1>
        <p>Every plan starts with 14 days free. Prices below are in naira; outside Nigeria you'll see them in your own currency when you sign up.</p>
        <nav class="jump" aria-label="On this page"><a href="#workforce">Chelkron Workforce</a><a href="#mail">Chelkron Mail</a><a href="#bundle">Free Mail with Workforce</a><a href="#questions">Questions</a></nav>
    </div>
</section>

<section class="plans-sec" id="workforce" aria-labelledby="wf-h">
    <div class="wrap">
        <h2 id="wf-h" class="plans-h"><img src="/assets/workforce-icon.svg" alt="" width="36" height="36">Chelkron Workforce</h2>
        <p class="sec-p">CRM, HR, payroll, leave, appraisals, tasks and team chat. <a href="/workforce">See what's included</a></p>
        <?php site_plan_cards('workforce'); ?>
    </div>
</section>

<section class="plans-sec plans-alt" id="mail" aria-labelledby="mail-h">
    <div class="wrap">
        <h2 id="mail-h" class="plans-h"><img src="/assets/mail-icon.svg" alt="" width="36" height="36">Chelkron Mail</h2>
        <p class="sec-p">Professional email on your own domain. <a href="/mail">See what's included</a></p>
        <?php site_plan_cards('mail'); ?>
    </div>
</section>

<section class="bundle-band" id="bundle" aria-labelledby="bundle-h">
    <div class="wrap bundle-in bundle-steps">
        <div>
            <p class="eyebrow">Better together</p>
            <h2 id="bundle-h">Get Workforce. Get Mail free.</h2>
            <p>Choose Workforce Starter, Growth or Enterprise, and we add Chelkron Mail Starter at no cost: 5 professional mailboxes on your own domain, free for up to 12 months while your Workforce plan stays active.</p>
        </div>
        <ol class="steps">
            <li><b>Pay for 3 months of Workforce</b>Or pay yearly, which counts as 12, and you qualify on day one.</li>
            <li><b>We email you a code</b>It's also on your Workforce Billing page.</li>
            <li><b>Enter it in Chelkron Mail</b>Create a Mail account, open Billing and redeem the code.</li>
        </ol>
        <p class="small">The offer applies to the Workforce Starter, Growth and Enterprise plans, once per workspace. Free Mail lasts up to 12 months while your Workforce subscription is active. Domain registration is not included.</p>
    </div>
</section>

<section class="faq" id="questions" aria-labelledby="faq-h">
    <div class="wrap">
        <h2 id="faq-h" class="sec-h">Questions</h2>
        <div class="faq-list">
            <details><summary>What happens after the 14 free days?</summary><p>Choose a plan and pay to keep going. If you don't, your account pauses. Your data stays safe, and paying unlocks it straight away.</p></details>
            <details><summary>How do I pay?</summary><p>Online through Paystack or Flutterwave, monthly or yearly. Yearly plans are paid once, upfront, for 12 months, at <?= SITE_YEARLY_OFF ?>% off.</p></details>
            <details><summary>Can I change plans later?</summary><p>Yes. Move up or down from the Billing page in the app whenever your team changes size.</p></details>
            <details><summary>I'm not in Nigeria. What will I pay?</summary><p>When you sign up, prices show in your local currency. The naira prices on this page are for Nigeria.</p></details>
            <details><summary>Is a domain included with Chelkron Mail?</summary><p>No. You can bring a domain you already own for free, or search for and buy one at <a href="https://domains.chelkron.com/">domains.chelkron.com</a>. Domain registration is billed separately.</p></details>
            <details><summary>We're bigger than the largest plan.</summary><p>Talk to us at <a href="mailto:business@chelkron.com">business@chelkron.com</a> and we'll put together a plan for you.</p></details>
        </div>
        <p class="small">Prices are correct at the time of writing and may change. The price you pay is the one shown at checkout.</p>
    </div>
</section>

<?php site_foot(); ?>
