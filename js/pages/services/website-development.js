/**
 * Website Development Page Interactions
 * - Technology Stack Category Filter Tabs
 * - Smooth anchor scrolling & animated counters in hero browser preview
 */
(function () {
  'use strict';

  // 1. Technology Stack Filter Tabs
  var tabContainer = document.querySelector('[data-wd-tabs]');
  var stackCards   = document.querySelectorAll('[data-wd-cat]');

  if (tabContainer && stackCards.length) {
    tabContainer.addEventListener('click', function (e) {
      var btn = e.target.closest('.wd-stack-tab');
      if (!btn) return;

      var filter = btn.getAttribute('data-filter');

      // Update active state on buttons
      tabContainer.querySelectorAll('.wd-stack-tab').forEach(function (t) {
        t.classList.toggle('is-active', t === btn);
        t.setAttribute('aria-selected', t === btn ? 'true' : 'false');
      });

      // Filter cards
      stackCards.forEach(function (card) {
        var cat = card.getAttribute('data-wd-cat');
        var show = (filter === 'all' || cat === filter);
        card.classList.toggle('is-hidden', !show);
      });
    });
  }

  // 2. Hero Browser Mockup Interactive Metric Cycle
  var previewViews = [
    {
      tag: 'Core Web Vitals · Passed',
      title: 'Conversion-Engineered Architecture',
      desc: 'Mobile-first responsive layout, sub-2s page load & schema-ready HTML.',
      load: '1.1s',
      perf: '99/100',
      conv: '+240%'
    },
    {
      tag: 'E-Commerce & Lead Funnels',
      title: 'Built to Turn Visitors Into Buyers',
      desc: 'Frictionless checkout, CRM & WhatsApp automation connected from day one.',
      load: '1.3s',
      perf: '98/100',
      conv: '+3.8x'
    },
    {
      tag: 'SEO & AI Search Ready',
      title: 'Structured to Rank & Be Cited',
      desc: 'Clean semantic markup, technical SEO foundations & local authority signals.',
      load: '0.9s',
      perf: '100/100',
      conv: 'Top 3'
    }
  ];

  var cardTag   = document.getElementById('wdPreviewTag');
  var cardTitle = document.getElementById('wdPreviewTitle');
  var cardDesc  = document.getElementById('wdPreviewDesc');
  var valLoad   = document.getElementById('wdValLoad');
  var valPerf   = document.getElementById('wdValPerf');
  var valConv   = document.getElementById('wdValConv');

  if (cardTag && cardTitle && cardDesc && valLoad && valPerf && valConv) {
    var idx = 0;
    setInterval(function () {
      idx = (idx + 1) % previewViews.length;
      var v = previewViews[idx];
      cardTag.textContent   = v.tag;
      cardTitle.textContent = v.title;
      cardDesc.textContent  = v.desc;
      valLoad.textContent   = v.load;
      valPerf.textContent   = v.perf;
      valConv.textContent   = v.conv;
    }, 4500);
  }
})();
