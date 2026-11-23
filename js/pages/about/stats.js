(function () {
  var nums = document.querySelectorAll('[data-count]');
  if (!nums.length) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (!e.isIntersecting) return;
      io.unobserve(e.target);

      var el = e.target;
      var end = +el.getAttribute('data-count');
      var start = null, dur = 1600;

      function step(t) {
        if (!start) start = t;
        var p = Math.min((t - start) / dur, 1);
        el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    });
  }, { threshold: 0.6 });

  nums.forEach(function (el) { io.observe(el); });
})();