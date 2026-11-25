(function () {
  var tl = document.getElementById('journeyTimeline');
  if (!tl) return;

  var scroller = document.getElementById('journeyScroller');
  var dot = document.getElementById('journeyDot');
  var steps = [].slice.call(tl.querySelectorAll('.journey__step'));
  var cur = 0, timer = null, played = false;

  function isMobile() {
    return window.matchMedia('(max-width: 767px)').matches;
  }

  function place(i) {
    var s = steps[i];
    if (isMobile()) {
      dot.style.left = '';
      dot.style.top = (s.offsetTop + 14) + 'px';
    } else {
      dot.style.top = '';
      dot.style.left = (s.offsetLeft + s.offsetWidth / 2) + 'px';
    }
  }

  function set(i, scrollIntoView) {
    cur = i;
    steps.forEach(function (s, k) {
      s.classList.toggle('is-passed', k <= i);
      s.classList.toggle('is-active', k === i);
    });
    place(i);
    if (scrollIntoView && !isMobile() && scroller.scrollWidth > scroller.clientWidth) {
      var s = steps[i];
      scroller.scrollTo({
        left: s.offsetLeft - (scroller.clientWidth - s.offsetWidth) / 2,
        behavior: 'smooth'
      });
    }
  }

  function stop() { if (timer) { clearInterval(timer); timer = null; } }

  steps.forEach(function (s, i) {
    s.addEventListener('mouseenter', function () {
      if (window.matchMedia('(hover: hover)').matches) { stop(); set(i); }
    });
    s.addEventListener('click', function () { stop(); set(i, true); });
  });

  set(0);
  window.addEventListener('load', function () { place(cur); });
  window.addEventListener('resize', function () { place(cur); });

  /* auto-advance once when the section scrolls into view */
  if ('IntersectionObserver' in window &&
      !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    var io = new IntersectionObserver(function (entries) {
      if (!entries[0].isIntersecting || played) return;
      played = true;
      io.disconnect();
      var i = 0;
      timer = setInterval(function () {
        i++;
        if (i >= steps.length) { stop(); return; }
        set(i, true);
      }, 1100);
    }, { threshold: 0.5 });
    io.observe(tl);
  }
})();