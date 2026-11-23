(function () {
  var el = document.querySelector('[data-scroll-highlight]');
  if (!el) return;

  var words = el.textContent.trim().split(/\s+/);
  el.setAttribute('aria-label', words.join(' '));
  el.innerHTML = words
    .map(function (w, i) {
      return '<span class="hl-word" aria-hidden="true" style="--i:' + i + '">' + w + '</span>';
    })
    .join(' ');

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        el.classList.add('is-in');
        io.unobserve(el);
      }
    });
  }, { threshold: 0.3 });

  io.observe(el);
})();