document.addEventListener('DOMContentLoaded', function () {

  var els = document.querySelectorAll('[data-count]');

  if (!els.length) return;

  function run(el) {
    var target = +el.getAttribute('data-count');
    var duration = 5000; // 5 seconds
    var start = null;

    function step(t) {
      if (!start) start = t;

      var p = Math.min((t - start) / duration, 1);
      var eased = 1 - Math.pow(1 - p, 3);

      el.textContent = Math.round(target * eased);

      if (p < 1) {
        requestAnimationFrame(step);
      }
    }

    requestAnimationFrame(step);
  }

  function setup(el) {
    el.textContent = '0';
  }

  if (!('IntersectionObserver' in window)) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        run(e.target);
        io.unobserve(e.target);
      }
    });
  }, {
    threshold: 0.3
  });

  els.forEach(function (el) {
    setup(el);
    io.observe(el);
  });

});
