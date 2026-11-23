(function () {
  var media = document.querySelector('[data-who-media]');
  if (!media) return;

  var frame = media.querySelector('.about-who__frame');
  var img = frame.querySelector('img');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // reveal when it enters the screen
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) {
        media.classList.add('is-in');
        io.unobserve(media);
      }
    });
  }, { threshold: 0.25 });
  io.observe(media);

  if (reduce) return;

  
  var ticking = false;
  function update() {
    var vh = window.innerHeight;
    var r = frame.getBoundingClientRect();
    var p = (vh - r.top) / (vh + r.height);   
    p = Math.min(Math.max(p, 0), 1);
    img.style.setProperty('--py', (-p * r.height * 0.15) + 'px');
    ticking = false;
  }
  function onScroll() {
    if (!ticking) { requestAnimationFrame(update); ticking = true; }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  update();
})();