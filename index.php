<?php
require __DIR__ . '/inc/layout.php';
require __DIR__ . '/inc/prices.php';
site_head('', 'Chelkron Technologies builds software that African businesses run on. Chelkron Workforce runs your team; Chelkron Mail gives you email on your own domain.', '/'); ?>

<section class="hero">
    <?php require __DIR__ . '/inc/parts/arc.svg.php'; ?>
    <div class="wrap hero-in">
        <h1>We build the software African businesses run on.</h1>
        <p class="lead">Your team, your sales, your payroll and your email, running from one place, on your phone, in your currency.</p>
        <div class="hero-cta">
            <a class="btn btn-light" href="/pricing">Start free for 14 days</a>
            <a class="btn btn-line" href="#products">See the products</a>
        </div>
    </div>
</section>

<section class="familiar" aria-labelledby="familiar-h">
    <div class="wrap familiar-in">
        <h2 id="familiar-h" class="sec-h">Sound familiar?</h2>
        <ul class="pains">
            <li>Attendance in a notebook nobody checks.</li>
            <li>Payroll in a spreadsheet only one person understands.</li>
            <li>Your hottest lead, buried in someone's WhatsApp.</li>
            <li>A Gmail address on your business card.</li>
        </ul>
        <p class="familiar-fix"><b>Chelkron fixes all of it.</b> Workforce runs your people, your sales and your payroll. Mail puts your business name on every email your team sends.</p>
    </div>
</section>

<section class="products" id="products" aria-labelledby="products-h">
    <div class="wrap">
        <h2 id="products-h" class="sec-h">Our products</h2>
        <p class="sec-p">Each one works on its own. Use one, or both.</p>

        <article class="prod">
            <div class="prod-copy">
                <h3><img class="prod-icon" src="/assets/workforce-icon.svg" alt="" width="44" height="44">Chelkron Workforce</h3>
                <p class="prod-lead">Your whole company. One app.</p>
                <ul class="feat">
                    <li><b>People</b>Staff records, roles and profiles</li>
                    <li><b>Attendance</b>Clock-in from the phone, with location checks</li>
                    <li><b>Payroll</b>Salaries, tax, pension and payslips</li>
                    <li><b>Sales</b>Leads, pipeline and targets</li>
                    <li><b>Work</b>Tasks, reports, calendar and team chat</li>
                </ul>
                <div class="prod-cta">
                    <a class="btn btn-blue" href="/workforce">Explore Workforce</a>
                    <span class="from">From <?= site_naira(site_yearly(SITE_PLANS['workforce']['plans'][0]['price'])[0]) ?>/month, paid yearly</span>
                </div>
            </div>
            <?php require __DIR__ . '/inc/parts/shot-workforce.php'; ?>
        </article>

        <article class="prod prod-alt">
            <div class="prod-copy">
                <h3><img class="prod-icon" src="/assets/mail-icon.svg" alt="" width="44" height="44">Chelkron Mail</h3>
                <p class="prod-lead">Look like the big company you're becoming.</p>
                <ul class="feat">
                    <li><b>Your address</b>you@yourcompany.com, for everyone on your team</li>
                    <li><b>Any device</b>Webmail, Outlook, and the mail app on your phone</li>
                    <li><b>Delivered</b>SPF, DKIM and DMARC set up with you, step by step</li>
                    <li><b>Domains</b>Search, buy or bring the domain you already have</li>
                </ul>
                <div class="prod-cta">
                    <a class="btn btn-blue" href="/mail">Explore Mail</a>
                    <span class="from">From <?= site_naira(site_yearly(SITE_PLANS['mail']['plans'][0]['price'])[0]) ?>/month, paid yearly</span>
                </div>
            </div>
            <?php require __DIR__ . '/inc/parts/shot-mail.php'; ?>
        </article>
    </div>
</section>

<section class="bundle-band" aria-labelledby="bundle-h">
    <div class="wrap bundle-in">
        <div>
            <p class="eyebrow">Better together</p>
            <h2 id="bundle-h">Get Workforce. Get Mail free.</h2>
            <p>On Workforce Starter or above, Chelkron Mail Starter is free for up to 12 months: five professional mailboxes on your own domain. Pay Workforce yearly and it's yours from day one.</p>
        </div>
        <a class="btn btn-blue" href="/pricing#bundle">How it works</a>
    </div>
</section>

<section class="approach" aria-labelledby="approach-h">
    <div class="wrap">
        <h2 id="approach-h" class="sec-h">How we build</h2>
        <div class="principles">
            <div>
                <h3>Priced where you are</h3>
                <p>Prices show in your local currency across 54 African countries. You pay through Paystack or Flutterwave. No dollar card needed.</p>
            </div>
            <div>
                <h3>In your language</h3>
                <p>English, French, Arabic and Portuguese, including right-to-left layouts, so a whole team can use the same tools.</p>
            </div>
            <div>
                <h3>Made for real work</h3>
                <p>Designed for the phone in your hand as much as the computer on your desk, so your team can work from the office, the site or the road.</p>
            </div>
        </div>
        <p class="more-link"><a href="/about">More about Chelkron &rarr;</a></p>
    </div>
</section>

<?php site_foot(); ?>
