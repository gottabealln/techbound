/**
 * Construction Marketing Page Interactions
 * - Dynamic Project Acquisition Metric Switcher in Hero Mockup
 * - IntersectionObserver Animation for Case Study Progress Bars
 */
(function () {
  'use strict';

  // 1. Hero Mockup Live Construction Acquisition Scenario Switcher
  var scenarios = [
    {
      tag: 'Luxury Custom Villa Builders',
      title: 'High-Ticket Residential Pipeline',
      desc: 'Local search dominance, video walkthrough showcase & NRI investor targeted funnels.',
      val1: '₹4.5 Cr+',
      val2: '14 / mo',
      val3: '95%'
    },
    {
      tag: 'Commercial General Contractors',
      title: 'Institutional & Corporate RFPs',
      desc: 'Shortening 18-month sales cycles with multi-stakeholder nurturing & verified case proof.',
      val1: '₹12 Cr+',
      val2: '6 RFPs',
      val3: '88%'
    },
    {
      tag: 'Premium Renovation & Remodeling',
      title: 'High-Margin Architectural Works',
      desc: 'Google Maps top-3 rankings, 5-star reputation consolidation & transformation galleries.',
      val1: '₹85 L+',
      val2: '24 / mo',
      val3: '92%'
    }
  ];

  var cardTag   = document.getElementById('cnPreviewTag');
  var cardTitle = document.getElementById('cnPreviewTitle');
  var cardDesc  = document.getElementById('cnPreviewDesc');
  var val1El    = document.getElementById('cnVal1');
  var val2El    = document.getElementById('cnVal2');
  var val3El    = document.getElementById('cnVal3');

  if (cardTag && cardTitle && cardDesc && val1El && val2El && val3El) {
    var idx = 0;
    setInterval(function () {
      idx = (idx + 1) % scenarios.length;
      var s = scenarios[idx];
      cardTag.textContent   = s.tag;
      cardTitle.textContent = s.title;
      cardDesc.textContent  = s.desc;
      val1El.textContent    = s.val1;
      val2El.textContent    = s.val2;
      val3El.textContent    = s.val3;
    }, 4500);
  }

  // 2. Animated Progress Bars on Scroll
  var progressBars = document.querySelectorAll('.cn-progress-bar');
  if (progressBars.length && 'IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          var bar = entry.target;
          var targetWidth = bar.getAttribute('data-width');
          if (targetWidth) {
            bar.style.width = targetWidth;
          }
          observer.unobserve(bar);
        }
      });
    }, { threshold: 0.2 });

    progressBars.forEach(function (bar) {
      bar.style.width = '0%';
      observer.observe(bar);
    });
  }
})();
