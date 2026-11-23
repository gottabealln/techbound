(function () {
  var box = document.querySelector('.word-rotator');
  if (!box) return;

  var words = box.dataset.words.split(',').map(function (w) { return w.trim(); });
  if (words.length < 2) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var current = box.querySelector('.word-rotator__word');
  var i = 0;
  var DELAY = 2200;                       // how long each word stays (ms)

  function start() {
    box.style.width = current.offsetWidth + 'px';

    function next() {
      i = (i + 1) % words.length;

      var incoming = document.createElement('span');
      incoming.className = 'word-rotator__word is-in';
      incoming.textContent = words[i];
      box.appendChild(incoming);

      current.classList.add('is-out');
      box.style.width = incoming.offsetWidth + 'px';

      var old = current;
      current = incoming;
      setTimeout(function () { old.remove(); }, 500);
    }

    setTimeout(function () { setInterval(next, DELAY); }, 1200);
  }

  // wait for the web font so the width is measured correctly
  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(start);
  } else {
    window.addEventListener('load', start);
  }
})();