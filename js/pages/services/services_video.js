(function () {
  var vids = document.querySelectorAll('.svc-block__video');
  if (!vids.length) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      var v = entry.target;
      if (entry.isIntersecting) {
        var p = v.play();
        if (p && p.catch) p.catch(function () {});
      } else {
        v.pause();
      }
    });
  }, { threshold: 0.35 });

  vids.forEach(function (v) { io.observe(v); });
})();