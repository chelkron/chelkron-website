<?php
require __DIR__ . '/inc/layout.php';
require __DIR__ . '/inc/prices.php';
site_head('', 'Chelkron Technologies builds software that African businesses run on. Chelkron Workforce runs your team, Chelkron Mail gives you email on your own domain, and Chelkron Sites puts your business online.', '/'); ?>

<section class="hero hero-mesh">
    <div class="mesh" aria-hidden="true"></div>
    <div class="wrap hero-in hero-grid">
        <div>
            <a class="pill" href="https://sites.chelkron.com"><b>New</b> Chelkron Sites: your business online today</a>
            <h1>We build the software African businesses run on.</h1>
            <p class="lead">Your team, your sales, your payroll, your email and your website, running from one place, on your phone, in your currency.</p>
            <div class="hero-cta">
                <a class="btn btn-blue btn-arrow" href="/pricing">Start free for 14 days</a>
                <a class="btn btn-ghost btn-arrow" href="#products">See the products</a>
            </div>
        </div>
        <div class="apps" aria-hidden="true">
            <div class="app-card ac-wf">
                <div class="ac-h"><img src="/assets/workforce-icon.svg" alt="" width="28" height="28"><span><b>Workforce</b><small>Good morning, Ada</small></span></div>
                <div class="ac-stats"><div><small>Present today</small><b>18/21</b></div><div><small>Pipeline</small><b>₦48.2m</b></div><div><small>Payroll</small><b class="ok">Paid</b></div></div>
                <div class="ac-row"><span class="dot t"></span>Send proposal to Okrika Foods<em>Due Friday</em></div>
            </div>
            <div class="app-card ac-mail">
                <div class="ac-h"><img src="/assets/mail-icon.svg" alt="" width="28" height="28"><span><b>Mail</b><small>ceo@yourbusiness.com</small></span></div>
                <div class="ac-row"><span class="av">CO</span><b>Chika Obi</b>&nbsp;· Quarterly report<em>09:41</em></div>
                <div class="ac-dns"><span>SPF</span><span>DKIM</span><span>DMARC</span><i>Verified</i></div>
            </div>
            <div class="app-card ac-sites">
                <div class="ac-h"><img src="/assets/sites-icon.svg" alt="" width="28" height="28"><span><b>Sites</b><small>mamaada.chelkron.site</small></span></div>
                <div class="ac-order"><span class="n">₦</span><span><b>New order · ₦72,000</b><small>Pay on delivery · Rumuola</small></span></div>
            </div>
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
        <p class="familiar-fix"><b>Chelkron fixes all of it.</b> Workforce runs your people, your sales and your payroll. Mail puts your business name on every email your team sends. Sites puts your business online, with a shop customers can buy from.</p>
    </div>
</section>

<section class="products" id="products" aria-labelledby="products-h">
    <div class="wrap">
        <p class="sec-kicker">Products</p>
        <h2 id="products-h" class="sec-h">Our products</h2>
        <p class="sec-p">Each one works on its own. Use one, or all three.</p>

        <article class="prod">
            <div class="prod-copy">
                <h3><img class="prod-icon" src="/assets/workforce-icon.svg" alt="" width="44" height="44">Chelkron Workforce</h3>
                <p class="prod-lead">Your whole company. One app.</p>
                <ul class="feat">
                    <li><b>People</b>Staff records, roles and profiles</li>
                    <li><b>Attendance</b>Clock-in from the phone, with location checks</li>
                    <li><b>Leave</b>Requests, approvals, balances and holidays</li>
                    <li><b>Payroll</b>Salaries, tax and payslips, linked to attendance</li>
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
                    <li><b>Domains</b><span>Buy one at <a href="https://domains.chelkron.com/">domains.chelkron.com</a>, or bring the domain you already have</span></li>
                </ul>
                <div class="prod-cta">
                    <a class="btn btn-blue" href="/mail">Explore Mail</a>
                    <span class="from">From <?= site_naira(site_yearly(SITE_PLANS['mail']['plans'][0]['price'])[0]) ?>/month, paid yearly</span>
                </div>
            </div>
            <?php require __DIR__ . '/inc/parts/shot-mail.php'; ?>
        </article>

        <article class="prod">
            <div class="prod-copy">
                <h3><img class="prod-icon" src="/assets/sites-icon.svg" alt="" width="44" height="44">Chelkron Sites</h3>
                <p class="prod-lead">A beautiful website for your business, ready today.</p>
                <ul class="feat">
                    <li><b>Templates</b>Shops, restaurants, salons, churches, schools, consultants and more</li>
                    <li><b>Edit on the page</b>Type straight onto your website; no designer needed</li>
                    <li><b>Sell</b>A cart with pay on delivery, bank transfer or Paystack, straight to you</li>
                    <li><b>Grow</b>Bookings, messages, Google-ready pages and a weekly overview</li>
                </ul>
                <div class="prod-cta">
                    <a class="btn btn-blue" href="https://sites.chelkron.com">Explore Sites</a>
                    <span class="from">14 days free, no card needed</span>
                </div>
            </div>
            <?php require __DIR__ . '/inc/parts/shot-sites.php'; ?>
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

<section class="approach approach-dark" aria-labelledby="approach-h">
    <div class="glow" aria-hidden="true"></div>
    <div class="wrap">
        <p class="sec-kicker">Our approach</p>
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
