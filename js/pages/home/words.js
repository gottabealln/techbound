(function () {
  var els = document.querySelectorAll('[data-words]');
  if (!els.length) return;

  els.forEach(function (el) {
    var text = el.textContent.replace(/\s+/g, ' ').trim();
    var words = text.split(' ');

    el.setAttribute('aria-label', text);   // screen readers read the sentence once
    el.textContent = '';

    words.forEach(function (word, i) {
      var span = document.createElement('span');
      span.className = 'w';
      span.setAttribute('aria-hidden', 'true');
      span.style.setProperty('--i', i);
      span.textContent = word;
      el.appendChild(span);
      if (i < words.length - 1) el.appendChild(document.createTextNode(' '));
    });

    el.classList.add('is-split');
  });

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.4 });

  els.forEach(function (el) { io.observe(el); });
})();