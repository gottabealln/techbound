(function () {
  var menu = document.getElementById('mobileMenu');
  if (!menu) return;

  function setOpen(item, open) {
    item.classList.toggle('is-open', open);
    item.querySelector('.m-trigger').setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  menu.addEventListener('click', function (e) {
    var btn = e.target.closest('.m-trigger');
    if (!btn) return;

    var item   = btn.closest('.m-item');
    var isOpen = item.classList.contains('is-open');

    // accordion: close the others, like the Enfin menu
    menu.querySelectorAll('.m-item.is-open').forEach(function (o) {
      if (o !== item) setOpen(o, false);
    });
    setOpen(item, !isOpen);
  });
})();