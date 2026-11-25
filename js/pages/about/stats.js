(function () {
  var nums = document.querySelectorAll('[data-count]');
  if (!nums.length) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (!e.isIntersecting) return;
      io.unobserve(e.target);

      var el = e.target;
      var raw = el.getAttribute('data-count') || '0';
      var decimals = raw.indexOf('.') !== -1 ? raw.split('.')[1].length : 0;
      var end = parseFloat(raw);
      var start = null, dur = 1600;

      function step(t) {
        if (!start) start = t;
        var p = Math.min((t - start) / dur, 1);
        var val = end * (1 - Math.pow(1 - p, 3));
        el.textContent = decimals > 0 ? val.toFixed(decimals) : Math.round(val);
        if (p < 1) {
          requestAnimationFrame(step);
        } else {
          el.textContent = decimals > 0 ? end.toFixed(decimals) : String(Math.round(end));
        }
      }
      requestAnimationFrame(step);
    });
  }, { threshold: 0.6 });

  nums.forEach(function (el) { io.observe(el); });
})();