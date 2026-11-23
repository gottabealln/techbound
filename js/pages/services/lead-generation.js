/**
 * Lead Generation Page Interactions
 * - Industry Filter Tabs
 * - Dynamic Pipeline Scenario Rotation in Hero Mockup
 */
(function () {
  'use strict';

  // 1. Industry Sector Filter Tabs
  var tabContainer = document.querySelector('[data-lg-tabs]');
  var indCards     = document.querySelectorAll('[data-lg-ind]');

  if (tabContainer && indCards.length) {
    tabContainer.addEventListener('click', function (e) {
      var btn = e.target.closest('.lg-ind-tab');
      if (!btn) return;

      var filter = btn.getAttribute('data-filter');

      // Update active state on buttons
      tabContainer.querySelectorAll('.lg-ind-tab').forEach(function (t) {
        t.classList.toggle('is-active', t === btn);
        t.setAttribute('aria-selected', t === btn ? 'true' : 'false');
      });

      // Filter cards
      indCards.forEach(function (card) {
        var cat = card.getAttribute('data-lg-ind');
        var show = (filter === 'all' || cat === filter);
        card.classList.toggle('is-hidden', !show);
      });
    });
  }

  // 2. Hero Pipeline Mockup Interactive Metric Cycle
  var scenarios = [
    {
      tag: 'B2B Services & Enterprise',
      title: 'Decision-Maker Inbound Pipeline',
      desc: 'Google Search intent + LinkedIn ABM outreach with automated CRM qualification.',
      leads: '48 / mo',
      cpl: '₹1,650',
      rate: '78%'
    },
    {
      tag: 'Real Estate & Properties',
      title: 'High-Intent Investor Inquiries',
      desc: 'Location-targeted Meta ads, virtual tour landing pages & instant WhatsApp routing.',
      leads: '84 / mo',
      cpl: '₹980',
      rate: '82%'
    },
    {
      tag: 'Healthcare & Specialized Clinics',
      title: 'Verified Patient Appointments',
      desc: 'Hyper-local search ads, doctor profile funnels & direct calendar bookings.',
      leads: '160 / mo',
      cpl: '₹420',
      rate: '91%'
    },
    {
      tag: 'Education & Professional Training',
      title: 'Admissions & Enrollment Funnel',
      desc: 'Multi-step qualification forms, syllabus downloads & automated email nurturing.',
      leads: '220 / mo',
      cpl: '₹350',
      rate: '86%'
    }
  ];

  var cardTag   = document.getElementById('lgPreviewTag');
  var cardTitle = document.getElementById('lgPreviewTitle');
  var cardDesc  = document.getElementById('lgPreviewDesc');
  var valLeads  = document.getElementById('lgValLeads');
  var valCpl    = document.getElementById('lgValCpl');
  var valRate   = document.getElementById('lgValRate');

  if (cardTag && cardTitle && cardDesc && valLeads && valCpl && valRate) {
    var idx = 0;
    setInterval(function () {
      idx = (idx + 1) % scenarios.length;
      var s = scenarios[idx];
      cardTag.textContent   = s.tag;
      cardTitle.textContent = s.title;
      cardDesc.textContent  = s.desc;
      valLeads.textContent  = s.leads;
      valCpl.textContent    = s.cpl;
      valRate.textContent   = s.rate;
    }, 4500);
  }
})();
