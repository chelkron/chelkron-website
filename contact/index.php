<?php
require __DIR__ . '/../inc/layout.php';
site_head('Contact', 'Questions about Chelkron Workforce or Chelkron Mail, setting up your account, or billing? Send us a message.', '/contact'); ?>

<section class="page-head">
    <div class="wrap">
        <h1>Talk to us</h1>
        <p>Questions about Workforce or Mail, setting up your account, or billing? Send us a message and we'll reply by email.</p>
    </div>
</section>

<section class="contact-page">
    <div class="wrap contact-grid">
        <div class="cf cf-inline">
            <form class="cf-form" id="cf-form" method="post" action="/contact.php">
                <h2>Send us a message</h2>
                <div class="cf-row">
                    <label>Your name<input name="name" type="text" maxlength="100" autocomplete="name" required></label>
                    <label>Email<input name="email" type="email" maxlength="150" autocomplete="email" required></label>
                </div>
                <div class="cf-row">
                    <label><span>Company <small>(optional)</small></span><input name="company" type="text" maxlength="120" autocomplete="organization"></label>
                    <label>About
                        <select name="topic">
                            <option>Chelkron Workforce</option>
                            <option>Chelkron Mail</option>
                            <option>Billing</option>
                            <option>Something else</option>
                        </select>
                    </label>
                </div>
                <label>Message<textarea name="message" rows="6" maxlength="5000" minlength="10" required></textarea></label>
                <label class="cf-hp" aria-hidden="true">Leave this empty<input name="website" type="text" tabindex="-1" autocomplete="off"></label>
                <input type="hidden" name="t" value="0">
                <p class="cf-msg" id="cf-msg" role="alert" hidden></p>
                <button type="submit" class="btn btn-blue" id="cf-btn">Send message</button>
            </form>
            <div class="cf-done" id="cf-done" tabindex="-1" role="status" hidden>
                <h2>Message sent</h2>
                <p></p>
                <a class="btn btn-ghost" href="/">Back to the home page</a>
            </div>
        </div>
        <aside class="contact-side">
            <div>
                <h3>Already a customer?</h3>
                <p>Live chat, WhatsApp and support requests are on our support site.</p>
                <a class="btn btn-ghost" href="https://support.chelkron.com/">Get support</a>
            </div>
            <div>
                <h3>Larger teams and partnerships</h3>
                <p>More than 75 staff or 50 mailboxes, or want to work with us?</p>
                <a href="mailto:business@chelkron.com">business@chelkron.com</a>
            </div>
            <div>
                <h3>Where we are</h3>
                <p>Chelkron Technologies Limited<br>Port Harcourt, Nigeria</p>
            </div>
        </aside>
    </div>
</section>

<?php site_foot(false); ?>
