(function () {
  var viewport = document.getElementById('ceoViewport');
  var track = document.getElementById('ceoTrack');
  if (!viewport || !track) return;

  var slides = track.children;
  var n = slides.length;
  var dotsBox = document.getElementById('ceoDots');
  var idx = 0, timer = null;
  var PAUSE_MS = 5000;           // time each leader stays on screen

  // dots
  var dots = [];
  for (var i = 0; i < n; i++) {
    (function (k) {
      var b = document.createElement('button');
      b.type = 'button';
      b.setAttribute('aria-label', 'Show leader ' + (k + 1));
      b.addEventListener('click', function () { go(k); restart(); });
      dotsBox.appendChild(b);
      dots.push(b);
    })(i);
  }
  dotsBox.removeAttribute('aria-hidden');

  function go(k) {
    idx = (k + n) % n;
    track.style.transform = 'translateX(-' + (idx * 100) + '%)';
    dots.forEach(function (d, j) { d.classList.toggle('is-active', j === idx); });
  }

  function stop() { if (timer) { clearInterval(timer); timer = null; } }
  function start() {
    stop();
    timer = setInterval(function () { go(idx + 1); }, PAUSE_MS);
  }
  function restart() { start(); }

  document.getElementById('ceoPrev').addEventListener('click', function () { go(idx - 1); restart(); });
  document.getElementById('ceoNext').addEventListener('click', function () { go(idx + 1); restart(); });

  // swipe (the timer only pauses while a finger or mouse button is held down)
  var startX = null;
  viewport.addEventListener('pointerdown', function (e) { startX = e.clientX; stop(); });
  window.addEventListener('pointerup', function (e) {
    if (startX === null) return;
    var dx = e.clientX - startX;
    startX = null;
    if (Math.abs(dx) > 50) go(dx < 0 ? idx + 1 : idx - 1);
    start();
  });

  go(0);
  start();     // starts straight away and keeps running
})();