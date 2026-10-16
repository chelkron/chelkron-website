/* chelkron.com — shared by every page: the phone menu, the footer year, and the contact form on /contact. */
document.getElementById('yr').textContent = new Date().getFullYear();

// Phone menu: opens full screen, closes with the X, Escape or by choosing a link.
function menu(open) {
    var m = document.getElementById('menu'), btn = document.querySelector('.menu-btn');
    m.hidden = !open;
    document.body.classList.toggle('menu-open', open);
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    (open ? m.querySelector('.menu-x') : btn).focus({ preventScroll: true });
}
document.addEventListener('keydown', function (e) {
    var m = document.getElementById('menu');
    if (m.hidden) return;
    if (e.key === 'Escape') { menu(false); return; }
    if (e.key === 'Tab') {   // keep focus inside the open menu
        var f = m.querySelectorAll('a, button'), first = f[0], last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    }
});
window.addEventListener('resize', function () { if (window.innerWidth > 860 && !document.getElementById('menu').hidden) menu(false); });

// Contact form (/contact). Without JavaScript it still posts to /contact.php, which sends the visitor back here.
(function () {
    var f = document.getElementById('cf-form');
    if (!f) return;
    var opened = Date.now(), btn = document.getElementById('cf-btn'), msg = document.getElementById('cf-msg'), done = document.getElementById('cf-done');
    function show(text, ok) {
        if (ok) { f.hidden = true; done.querySelector('p').textContent = text; done.hidden = false; done.focus(); return; }
        msg.textContent = text; msg.hidden = false;
    }
    var q = new URLSearchParams(location.search);
    if (q.get('topic')) { for (var i = 0; i < f.topic.options.length; i++) if (f.topic.options[i].value === q.get('topic')) f.topic.selectedIndex = i; }
    if (q.get('sent')) show('Thanks — your message is on its way. We\'ll reply by email.', true);
    else if (q.get('error')) show(q.get('error'), false);
    f.addEventListener('submit', function (e) {
        if (!window.fetch) return;
        e.preventDefault();
        f.t.value = Math.max(1, Date.now() - opened);   // how long the form was open (a bot guard)
        btn.disabled = true; btn.textContent = 'Sending…'; msg.hidden = true;
        fetch(f.action, { method: 'POST', body: new FormData(f), headers: { Accept: 'application/json' } })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                btn.disabled = false; btn.textContent = 'Send message';
                if (!res.ok) { show(res.message, false); return; }
                f.reset(); show(res.message, true);
            })
            .catch(function () {
                btn.disabled = false; btn.textContent = 'Send message';
                show('We could not send your message just now. Please visit support.chelkron.com instead.', false);
            });
    });
})();
