(function () {
  'use strict';

  var buttons = document.querySelectorAll('.pf-filter');
  var cards = document.querySelectorAll('.pf-card');
  if (!buttons.length || !cards.length) return;

  buttons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var cat = btn.getAttribute('data-filter') || 'all';

      buttons.forEach(function (b) {
        var active = b === btn;
        b.classList.toggle('is-active', active);
        b.setAttribute('aria-pressed', active ? 'true' : 'false');
      });

      cards.forEach(function (card) {
        var cardCat = card.getAttribute('data-cat') || '';
        var show = cat === 'all' || cardCat === cat;
        card.classList.toggle('is-hidden', !show);
        if (show) {
          card.classList.add('is-visible');
        }
      });
    });
  });
})();
