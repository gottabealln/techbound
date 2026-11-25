document.addEventListener('DOMContentLoaded', function () {

  var els = document.querySelectorAll('[data-count]');

  if (!els.length) return;

  function run(el) {
    var raw = el.getAttribute('data-count') || '0';
    var decimals = raw.indexOf('.') !== -1 ? raw.split('.')[1].length : 0;
    var target = parseFloat(raw);
    var duration = 2200;
    var start = null;

    function step(t) {
      if (!start) start = t;

      var p = Math.min((t - start) / duration, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      var val = target * eased;

      el.textContent = decimals > 0 ? val.toFixed(decimals) : Math.round(val);

      if (p < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = decimals > 0 ? target.toFixed(decimals) : String(Math.round(target));
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
