<?php
require __DIR__ . '/../inc/layout.php';
require __DIR__ . '/../inc/prices.php';
site_head('Packages', 'Chelkron packs: your website, business email and staff software together, with one payment and one renewal date. From ' . site_naira(SITE_PACKS['starter']['price']) . ' a month.', '/packages'); ?>

<section class="page-head">
    <div class="wrap">
        <p class="eyebrow">Chelkron packs</p>
        <h1>Your website, email and team, with one payment.</h1>
        <p>Each pack brings Chelkron Sites, Chelkron Mail and Chelkron Workforce together for less than buying them separately. One payment, one renewal date, one place to manage it.</p>
        <nav class="jump" aria-label="On this page"><a href="#packs">The packs</a><a href="#how">How it works</a><a href="#questions">Questions</a></nav>
    </div>
</section>

<section class="plans-sec" id="packs" aria-labelledby="packs-h">
    <div class="wrap">
        <h2 id="packs-h" class="plans-h"><img src="/assets/sites-icon.svg" alt="" width="36" height="36"><img src="/assets/mail-icon.svg" alt="" width="36" height="36"><img src="/assets/workforce-icon.svg" alt="" width="36" height="36">Choose your pack</h2>
        <p class="sec-p">Prices are a month, in your currency. Pay for a year and get 2 months free.</p>
        <?php site_pack_cards(); ?>
        <p class="plans-more">Want just one product? See <a href="/pricing">all plans and prices</a>.</p>
    </div>
</section>

<section class="bundle-band" id="how" aria-labelledby="how-h">
    <div class="wrap bundle-in bundle-steps">
        <div>
            <p class="eyebrow">How it works</p>
            <h2 id="how-h">Ready in a few minutes.</h2>
            <p>You pay for your pack on Chelkron Sites. Your website, email and Workforce workspace all run until the same date, and renew together.</p>
        </div>
        <ol class="steps">
            <li><b>Choose a pack</b>Create your Chelkron Sites account, or sign in, and pick the website it's for.</li>
            <li><b>Pay once</b>Card, bank transfer or USSD through Paystack or Flutterwave, monthly or yearly.</li>
            <li><b>Set up email and Workforce</b>From your website's Plan and payment page: add your domain for email, and create your Workforce workspace in one click.</li>
        </ol>
    </div>
</section>

<section class="faq" id="questions" aria-labelledby="faq-h">
    <div class="wrap">
        <h2 id="faq-h" class="sec-h">Questions</h2>
        <div class="faq-list">
            <details><summary>I already use Chelkron Workforce or Chelkron Mail.</summary><p>That's fine. Use the same email address for your Chelkron Sites account. Your Mail account joins the pack, and when you set up Workforce you enter your workspace's admin password and it moves onto the pack. If you already pay for a bigger plan in either app, you keep it.</p></details>
            <details><summary>Is there a free trial?</summary><p>Chelkron Sites has its own 14-day free trial, so you can build your website first and buy the pack when you're ready. A pack starts as soon as it's paid.</p></details>
            <details><summary>What happens if I don't renew?</summary><p>Your website goes offline and your email and Workforce workspace pause. Nothing is deleted: renew the pack and everything comes back straight away.</p></details>
            <details><summary>Can I change packs?</summary><p>Yes. Choose a different pack, or a single Sites plan, when you renew on your website's Plan and payment page.</p></details>
            <details><summary>Is a domain included?</summary><p>No. Bring a domain you already own, or buy one from your website's Domains page. Domain registration is billed separately.</p></details>
            <details><summary>We need more than the Pro pack.</summary><p>Talk to us at <a href="mailto:business@chelkron.com">business@chelkron.com</a> and we'll put together a plan for you.</p></details>
        </div>
        <p class="small">Prices are correct at the time of writing and may change. The price you pay is the one shown at checkout.</p>
    </div>
</section>

<?php site_foot();
