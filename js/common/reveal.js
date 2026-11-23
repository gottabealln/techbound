(function () {
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var path = (window.location.pathname || '').toLowerCase();
  var isHome = path === '/' || path.endsWith('/index.php') || path.endsWith('/techbound/') || path.endsWith('/techbound');

  // =========================================================================
  // 1. AUTO-TAG TEXT & CARDS ON SUBPAGES FOR HOME-STYLE SCROLL REVEAL
  // =========================================================================
  if (!isHome) {
    // 1a. Word-by-word reveal on concise plain-text section lead paragraphs (just like home .services__lead)
    var leadSelectors = [
      '.svc-text',
      '.svc-block__intro',
      '.services__lead',
      '.about-stats__lead',
      '.about-ceo__lead',
      '.cta__lead',
      '.cr-lead',
      '.cn-lead',
      '.lg-lead',
      '.wd-lead',
      '.ads-lead',
      '.contact__lead',
      '.legal__intro'
    ].join(',');

    document.querySelectorAll(leadSelectors).forEach(function (el) {
      if (el.closest('.hero, .hero--inner, .page-banner, header, footer')) return;
      if (el.hasAttribute('data-words') || el.hasAttribute('data-animate') || el.classList.contains('is-split')) return;

      // Only word-split plain text paragraphs (no nested links/tags) up to 45 words;
      // otherwise give them the smooth slide-up text reveal.
      var hasChildElements = el.children.length > 0;
      var wordCount = el.textContent.replace(/\s+/g, ' ').trim().split(' ').filter(Boolean).length;

      if (!hasChildElements && wordCount > 0 && wordCount <= 45) {
        el.setAttribute('data-words', '');
        if (wordCount > 22) el.style.setProperty('--w-step', '35ms');
      } else {
        el.setAttribute('data-animate', 'up');
      }
    });

    // 1b. Slide-up scroll reveal on section pills, headings, paragraphs & cards across all subpages
    var textAndCardSelectors = [
      'section .pill',
      'section h2',
      '.svc-title',
      '.faq__title',
      '.cta__title',
      '.related-posts-title',
      '.about-who__title',
      '.about-who__text',
      '.about-ceo__quote',
      '.mv-col__title',
      '.mv-col__text',
      '.svc-block__list li',
      '.svc-incl__list li',
      '.svc-steps li',
      '.ai-feature',
      '.ai-v-step',
      '.wd-card',
      '.wd-track-card',
      '.wd-stack-card',
      '.wd-mistake',
      '.wd-review',
      '.lg-card',
      '.lg-track-card',
      '.lg-channel-card',
      '.lg-ind-card',
      '.lg-mistake',
      '.lg-review',
      '.ads-channel',
      '.ads-mistake',
      '.ads-review',
      '.smm-list-col',
      '.smm-channel-card',
      '.cn-track-card',
      '.cn-framework-card',
      '.cn-case-card',
      '.cn-step-card',
      '.cn-mistake',
      '.cr-value-item',
      '.cr-perk-card',
      '.cr-job-card',
      '.blog-card',
      '.blog-featured-card',
      '.team-card',
      '.journey__step',
      '.contact__list li'
    ].join(',');

    document.querySelectorAll(textAndCardSelectors).forEach(function (el) {
      if (el.closest('.hero, .hero--inner, .page-banner, .testimonials, header, footer')) return;
      if (el.closest('[data-animate]')) return; // avoid nesting animated children inside animated parents
      if (el.hasAttribute('data-animate') || el.hasAttribute('data-words') || el.classList.contains('is-visible')) return;
      el.setAttribute('data-animate', 'up');
    });
  }

  // =========================================================================
  // 2. WORD-BY-WORD SCROLL REVEAL ([data-words=""])
  // =========================================================================
  var wordEls = Array.prototype.slice.call(document.querySelectorAll('[data-words]')).filter(function (el) {
    // Skip word-rotator elements (e.g. about.php) which use data-words="Word1,Word2,..."
    return !el.classList.contains('word-rotator') && !el.getAttribute('data-words') && !el.classList.contains('is-split');
  });

  if (wordEls.length) {
    wordEls.forEach(function (el) {
      var text = el.textContent.replace(/\s+/g, ' ').trim();
      if (!text) return;
      var words = text.split(' ');

      el.setAttribute('aria-label', text);
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

    if (!('IntersectionObserver' in window) || reduce) {
      wordEls.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
      var wordIO = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            wordIO.unobserve(entry.target);
          }
        });
      }, { threshold: 0.25, rootMargin: '0px 0px -30px 0px' });

      wordEls.forEach(function (el) { wordIO.observe(el); });
    }
  }

  // =========================================================================
  // 3. SLIDE-UP SCROLL REVEAL ([data-animate]) — EXACT HOME PAGE TIMING
  // =========================================================================
  var items = document.querySelectorAll('[data-animate]');
  if (items.length) {
    if (!('IntersectionObserver' in window) || reduce) {
      items.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
      var observer = new IntersectionObserver(function (entries, obs) {
        var batch = entries
          .filter(function (e) { return e.isIntersecting; })
          .map(function (e) { return e.target; });

        // top-to-bottom, left-to-right
        batch.sort(function (a, b) {
          return (a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING) ? -1 : 1;
        });

        batch.forEach(function (el, i) {
          if (!el.style.getPropertyValue('--d')) el.style.setProperty('--d', (i * 120) + 'ms');
          var d = parseInt(el.style.getPropertyValue('--d'), 10) || 0;

          el.classList.add('is-visible');
          obs.unobserve(el);

          // once revealed, drop the delay so hover effects respond instantly
          setTimeout(function () { el.style.setProperty('--d', '0ms'); }, d + 1800);
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

      items.forEach(function (el) { observer.observe(el); });
    }
  }
})();

// Cards: highlight the card that is in the middle of the screen (styled on touch/mobile via CSS)
(function () {
  var cardSelectors = [
    '.service-card',
    '.ai-feature',
    '.ai-v-content',
    '.svc-hero-card',
    '.wd-card',
    '.wd-stack-card',
    '.wd-track-card',
    '.wd-mistake',
    '.wd-review',
    '.lg-card',
    '.lg-track-card',
    '.lg-channel-card',
    '.lg-ind-card',
    '.lg-mistake',
    '.lg-review',
    '.ads-channel',
    '.ads-mistake',
    '.ads-review',
    '.smm-list-col',
    '.smm-channel-card',
    '.cn-track-card',
    '.cn-mistake',
    '.cn-framework-card',
    '.cn-case-card',
    '.cn-step-card',
    '.cr-value-item',
    '.cr-perk-card',
    '.cr-job-card',
    '.mv-col',
    '.team-card'
  ].join(',');

  var cards = document.querySelectorAll(cardSelectors);
  if (!cards.length || !('IntersectionObserver' in window)) return;

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      e.target.classList.toggle('is-active', e.isIntersecting);
    });
  }, { rootMargin: '-42% 0px -42% 0px', threshold: 0 }); // a thin band across the middle of the screen

  cards.forEach(function (c) { io.observe(c); });
})();

// Fallback counter for subpages that use [data-count] without loading counter.js or stats.js
(function () {
  if (document.querySelector('script[src*="counter.js"], script[src*="stats.js"]')) return;
  var countEls = document.querySelectorAll('[data-count]');
  if (!countEls.length || !('IntersectionObserver' in window)) return;

  var counterObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      counterObserver.unobserve(entry.target);

      var el = entry.target;
      var rawVal = el.getAttribute('data-count');
      var end = parseFloat(rawVal);
      if (isNaN(end)) return;

      var isDecimal = rawVal.indexOf('.') !== -1;
      var decimalPlaces = isDecimal ? (rawVal.split('.')[1] || '').length : 0;
      var start = null;
      var duration = 1600;

      function animateCount(timestamp) {
        if (!start) start = timestamp;
        var progress = Math.min((timestamp - start) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        var current = end * eased;
        el.textContent = isDecimal ? current.toFixed(decimalPlaces) : Math.round(current);

        if (progress < 1) {
          requestAnimationFrame(animateCount);
        } else {
          el.textContent = rawVal;
        }
      }

      requestAnimationFrame(animateCount);
    });
  }, { threshold: 0.25 });

  countEls.forEach(function (el) { counterObserver.observe(el); });
})();
