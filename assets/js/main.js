/* Skilvara English Center - JavaScript utama */
(function () {
    'use strict';

    // Menu mobile
    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.querySelector('[data-nav]');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // FAQ: filter per kategori (tab)
    var tabs = document.querySelectorAll('[data-faq-tabs] .tab');
    var items = document.querySelectorAll('[data-faq-list] .faq-item');
    function showCategory(cat) {
        items.forEach(function (item) {
            item.hidden = item.dataset.cat !== cat;
            if (item.hidden) { item.open = false; }
        });
        var first = document.querySelector('[data-faq-list] .faq-item:not([hidden])');
        if (first) { first.open = true; }
    }
    if (tabs.length) {
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                tabs.forEach(function (t) { t.classList.remove('active'); });
                tab.classList.add('active');
                showCategory(tab.dataset.cat);
            });
        });
        showCategory(tabs[0].dataset.cat);
    }

    // Halaman pembayaran: ganti metode (QRIS / Transfer)
    var methods = document.querySelectorAll('[data-method]');
    methods.forEach(function (label) {
        label.addEventListener('click', function () {
            methods.forEach(function (m) { m.classList.remove('active'); });
            label.classList.add('active');
        });
    });
})();
