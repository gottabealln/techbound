
(function () {
  'use strict';

  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  const contactDrawer = document.getElementById('contactDrawer');
  const contactDrawerBackdrop = document.getElementById('contactDrawerBackdrop');
  const contactDrawerClose = document.getElementById('contactDrawerClose');

  function isDesktop() {
    return window.innerWidth >= 1024;
  }

  function setMobileMenu(open) {
    if (!mobileMenu || !menuBtn) return;
    mobileMenu.classList.toggle('is-open', open);
    menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    document.body.classList.toggle('menu-open', open);
  }

  function setContactDrawer(open) {
    if (!contactDrawer) return;
    contactDrawer.classList.toggle('is-open', open);
    contactDrawer.setAttribute('aria-hidden', open ? 'false' : 'true');
    if (contactDrawerBackdrop) {
      contactDrawerBackdrop.classList.toggle('is-open', open);
      contactDrawerBackdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
    }
    if (menuBtn) {
      menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    document.body.classList.toggle('drawer-open', open);
  }

  // Navbar right menu button: on desktop opens Contact Details Drawer; on mobile opens Navigation Menu
  if (menuBtn) {
    menuBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (isDesktop()) {
        const isOpen = contactDrawer && contactDrawer.classList.contains('is-open');
        setContactDrawer(!isOpen);
      } else {
        const isOpen = mobileMenu && mobileMenu.classList.contains('is-open');
        setMobileMenu(!isOpen);
      }
    });
  }

  if (contactDrawerClose) {
    contactDrawerClose.addEventListener('click', () => setContactDrawer(false));
  }

  if (contactDrawerBackdrop) {
    contactDrawerBackdrop.addEventListener('click', () => setContactDrawer(false));
  }

  // Close menus on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (contactDrawer && contactDrawer.classList.contains('is-open')) {
        setContactDrawer(false);
      }
      if (mobileMenu && mobileMenu.classList.contains('is-open')) {
        setMobileMenu(false);
      }
    }
  });

  if (mobileMenu) {
    mobileMenu.querySelectorAll('a').forEach(a =>
      a.addEventListener('click', () => setMobileMenu(false))
    );

    // Mobile submenu accordion (Services, Company)
    const mobileTriggers = mobileMenu.querySelectorAll('.has-sub > .nav-trigger');
    mobileTriggers.forEach(trigger => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        const li = trigger.closest('.has-sub');
        if (!li) return;
        const willOpen = !li.classList.contains('is-open');

        // Close sibling submenus for a clean accordion
        mobileMenu.querySelectorAll('.has-sub.is-open').forEach(other => {
          if (other !== li) {
            other.classList.remove('is-open');
            other.querySelector('.nav-trigger')?.setAttribute('aria-expanded', 'false');
          }
        });

        li.classList.toggle('is-open', willOpen);
        trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      });
    });
  }

  window.addEventListener('resize', () => {
    if (isDesktop()) {
      if (mobileMenu && mobileMenu.classList.contains('is-open')) {
        setMobileMenu(false);
      }
    } else {
      if (contactDrawer && contactDrawer.classList.contains('is-open')) {
        setContactDrawer(false);
      }
    }
  });


function scrollHighlight(el, dimFrom = Infinity) {
  const words = el.textContent.trim().split(' ');
  el.textContent = '';

  const spans = words.map((word, i) => {
    const span = document.createElement('span');
    span.className = 'word';
    span.textContent = word;
    el.appendChild(span);
    el.appendChild(document.createTextNode(' '));
    return span;
  });

  function update() {
    const rect = el.getBoundingClientRect();
    const start = window.innerHeight * 0.8;
    const p = Math.min(1, Math.max(0, (start - rect.top) / rect.height));
    const lit = p * words.length;

    spans.forEach((span, i) => {
      const on = lit > i;
      span.classList.toggle('is-lit', on && i < dimFrom);
      span.classList.toggle('is-dim', on && i >= dimFrom);
    });
  }

  update();
  window.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);
}

const aboutHeading = document.querySelector('.about__heading');
if (aboutHeading) scrollHighlight(aboutHeading);

/* ===== Navbar: hide on scroll down / show on scroll up + solid light/glass theme ===== */
const header = document.querySelector('.header');
let lastY = window.scrollY;
let navTicking = false;

function updateHeader() {
  if (!header) return;
  const y = window.scrollY;
  const menuOpen = mobileMenu && mobileMenu.classList.contains('is-open');

  // Probe point: height of the navbar area (approx 65px)
  const navBottom = 65;

  // 1. Detect if the navbar is over an explicit dark section (e.g. hero banner, cta)
  const darkSections = document.querySelectorAll('[data-nav="dark"], .hero, .svc-hero, .page-banner, .blog-hero, .careers-banner');
  const isOverDark = [...darkSections].some(s => {
    const r = s.getBoundingClientRect();
    return r.top < navBottom && r.bottom > 15;
  });

  // 2. Detect if the navbar is over an explicit light section
  const lightSections = document.querySelectorAll('[data-nav="light"], .intro, .services, .stack, .faq, .process, .blog, .contact, .about-mv, .about-stats, .about-who, .svc-block, .svc-section, .blog-main-section, .blog-post-content, .cr-culture, .cr-openings, .cr-process, .cr-faq');
  const isOverLight = [...lightSections].some(s => {
    const r = s.getBoundingClientRect();
    return r.top < navBottom && r.bottom > 15;
  });

  // Navbar turns solid white (no glass effect) whenever over a light section, or scrolled past the initial hero banner (> 80px) and not over an explicit dark section
  const overLight = isOverLight || (!isOverDark && y > 80);
  header.classList.toggle('is-light', overLight);

  // 3. Hide on scroll down, show on scroll up
  if (y <= 80 || menuOpen) {
    header.classList.remove('is-hidden');
  } else if (y > lastY + 5) {
    header.classList.add('is-hidden');
  } else if (y < lastY - 5) {
    header.classList.remove('is-hidden');
  }

  lastY = y;
  navTicking = false;
}

window.addEventListener('scroll', () => {
  if (!navTicking) {
    requestAnimationFrame(updateHeader);
    navTicking = true;
  }
}, { passive: true });

window.addEventListener('resize', updateHeader);
updateHeader();

/* ===== FAQ accordion ===== */
document.addEventListener('click', (e) => {
  const btn = e.target.closest('.faq__question');
  if (!btn) return;

  const item = btn.closest('.faq__item');
  const willOpen = !item.classList.contains('is-open');

  document.querySelectorAll('.faq__item').forEach(i => {
    i.classList.remove('is-open');
    i.querySelector('.faq__question').setAttribute('aria-expanded', 'false');
  });

  if (willOpen) {
    item.classList.add('is-open');
    btn.setAttribute('aria-expanded', 'true');
  }
});



/* ===== Mega menus (Work, Services, ...) ===== */
function initMegaMenus() {
  const triggers = document.querySelectorAll("[data-mega-trigger]");
  if (!triggers.length) return;

  // data-mega-trigger="work" -> #workMegaMenu
  function getMenu(trigger) {
    return document.getElementById(trigger.dataset.megaTrigger + "MegaMenu");
  }

  function setOpen(trigger, open) {
    const menu = getMenu(trigger);
    if (!menu) return;
    menu.classList.toggle("is-open", open);
    trigger.setAttribute("aria-expanded", open);
    trigger.closest(".has-sub")?.classList.toggle("is-open", open); // flips the arrow
  }

  function closeAll(except) {
    triggers.forEach(t => {
      if (t !== except) setOpen(t, false);
    });
  }

  triggers.forEach(trigger => {
    const menu = getMenu(trigger);
    if (!menu) return;

    trigger.addEventListener("click", function (event) {
      event.preventDefault();
      event.stopPropagation();
      const willOpen = !menu.classList.contains("is-open");
      closeAll(trigger);            // close the other mega menu first
      setOpen(trigger, willOpen);
    });

    menu.addEventListener("click", function (event) {
      event.stopPropagation();
    });
  });

  // click anywhere else closes everything
  document.addEventListener("click", () => closeAll());

  // Escape closes and returns focus to the trigger
  document.addEventListener("keydown", function (event) {
    if (event.key !== "Escape") return;
    const openTrigger = [...triggers].find(t => getMenu(t)?.classList.contains("is-open"));
    closeAll();
    openTrigger?.focus();
  });
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initMegaMenus);
} else {
  initMegaMenus();
}

/* ===== Our Process: dot follows scroll ===== */
function initProcessTimelines() {
  const timelines = document.querySelectorAll('.process__timeline');
  if (!timelines.length) return;

  timelines.forEach(timeline => {
    if (timeline.dataset.timelineInit === 'true') return;
    timeline.dataset.timelineInit = 'true';

    const dot = timeline.querySelector('.process__dot');
    const fill = timeline.querySelector('.process__fill');
    const steps = timeline.querySelectorAll('.process__step');

    if (!dot || !steps.length) return;

    let ticking = false;

    function update() {
      const rect = timeline.getBoundingClientRect();
      const trigger = window.innerHeight * 0.5;
      const raw = trigger - rect.top;

      // marker centre of each step (marker is top: 8px, 10px tall -> centre is 13px)
      const markers = Array.from(steps).map(s => s.offsetTop + 13);
      const first = markers[0];
      const last = markers[markers.length - 1];

      // the dot only travels from the first step marker to the last one
      const y = Math.min(last, Math.max(first, raw));
      dot.style.top = y + 'px';
      if (fill) fill.style.height = y + 'px';

      // active = the last step the dot is sitting on or has passed
      let current = -1;
      markers.forEach((m, i) => {
        if (y >= m - 2) current = i;
      });

      steps.forEach((s, i) => {
        s.classList.toggle('is-passed', i <= current);
        s.classList.toggle('is-active', i === current);
      });

      ticking = false;
    }

    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(update);
        ticking = true;
      }
    }, { passive: true });

    window.addEventListener('resize', update);
    update();
  });
}
window.initProcessTimelines = initProcessTimelines;
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initProcessTimelines);
} else {
  initProcessTimelines();
}

  /* ===== Floating FAQ Button Smooth Scroll ===== */
  document.addEventListener('click', function (e) {
    const faqBtn = e.target.closest('.floating-faq-btn');
    if (!faqBtn) return;
    const target = document.getElementById('faq');
    if (target) {
      e.preventDefault();
      const nav = document.querySelector('.navbar');
      const offset = (nav ? nav.offsetHeight : 80) + 20;
      const targetPos = target.getBoundingClientRect().top + window.pageYOffset - offset;
      window.scrollTo({
        top: Math.max(0, targetPos),
        behavior: 'smooth'
      });
      if (history.pushState) {
        history.pushState(null, null, '#faq');
      }
    }
  });

})();

/* ===== Book a Call Contact Popup Modal ===== */
(function () {
  const modal = document.getElementById('tbCallModal');
  if (!modal) return;

  const form = document.getElementById('tbCallModalForm');
  const statusEl = document.getElementById('tbCallModalStatus');
  const tsInput = document.getElementById('tbc-ts');
  const otherCb = document.getElementById('tbc-service-other-cb');
  const otherWrap = document.getElementById('tbc-other-wrap');
  const otherInput = document.getElementById('tbc-other-desc');
  const serviceHidden = document.getElementById('tbc-service');
  const defaultServiceVal = serviceHidden ? serviceHidden.value : 'Book a Call';

  function syncOtherField() {
    if (!otherCb || !otherWrap) return;
    const checked = otherCb.checked;
    otherWrap.hidden = !checked;
    if (otherInput) {
      otherInput.required = checked;
      if (checked) setTimeout(function () { otherInput.focus(); }, 40);
      else otherInput.value = '';
    }
  }

  if (otherCb) {
    otherCb.addEventListener('change', syncOtherField);
  }

  function openModal() {
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
    if (tsInput) tsInput.value = String(Math.floor(Date.now() / 1000));
    const firstInput = modal.querySelector('#tbc-name');
    if (firstInput) setTimeout(() => firstInput.focus(), 80);
  }

  function closeModal() {
    modal.hidden = true;
    document.body.style.overflow = '';
  }

  document.addEventListener('click', function (e) {
    const trigger = e.target.closest('[data-book-call]');
    if (trigger) {
      e.preventDefault();
      openModal();
      return;
    }
    if (e.target.closest('[data-close-call-modal]')) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.hidden) {
      closeModal();
    }
  });

  if (form && statusEl) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const btn = form.querySelector('button[type="submit"]');
      if (btn) btn.disabled = true;
      statusEl.className = 'tb-call-form__status';
      statusEl.textContent = 'Sending your request...';

      const selectedServices = Array.from(form.querySelectorAll('input[name="services_multi[]"]:checked'))
        .map(function (cb) {
          if (cb.value === 'Others' && otherInput && otherInput.value.trim()) {
            return 'Others (' + otherInput.value.trim() + ')';
          }
          return cb.value;
        });

      const fd = new FormData(form);
      if (selectedServices.length > 0) {
        fd.set('service', selectedServices.join(', ').slice(0, 80));
        const rawMsg = String(fd.get('message') || '').trim();
        fd.set('message', 'Selected Services: ' + selectedServices.join(', ') + '\n\n' + rawMsg);
      } else {
        fd.set('service', defaultServiceVal);
      }

      const getToken = (typeof window.tbGetRecaptchaToken === 'function')
        ? window.tbGetRecaptchaToken('book_call')
        : Promise.resolve('');

      getToken.then(function (token) {
        const tokenEl = document.getElementById('tbc-recaptcha-token');
        if (tokenEl) tokenEl.value = token || '';
        fd.set('recaptcha_token', token || '');
        return fetch(form.getAttribute('action'), {
          method: 'POST',
          body: fd
        });
      })
        .then(function (r) {
          return r.json().catch(function () { return { ok: false, message: 'Unexpected server response.' }; });
        })
        .then(function (data) {
          if (!data || !data.ok) {
            throw new Error((data && data.message) || 'Could not send your request. Please call +91 86064 97677.');
          }
          form.reset();
          syncOtherField();
          statusEl.className = 'tb-call-form__status is-ok';
          statusEl.textContent = data.message || 'Thank you! We will call you back within one working day.';
        })
        .catch(function (err) {
          statusEl.className = 'tb-call-form__status is-err';
          statusEl.textContent = (err && err.message) ? err.message : 'Could not send right now. Please call +91 86064 97677.';
        })
        .finally(function () {
          if (btn) btn.disabled = false;
        });
    });
  }
})();

/* ===== Smart Context-Aware Audit / Quick-Enquiry Modal ===== */
(function () {
  const modal = document.getElementById('tbAuditModal');
  if (!modal) return;

  const form        = document.getElementById('tbAuditModalForm');
  const statusEl    = document.getElementById('tbAuditModalStatus');
  const badgeText   = document.getElementById('tbAuditBadgeText');
  const titleEl     = document.getElementById('tbAuditModalTitle');
  const leadEl      = document.getElementById('tbAuditModalLead');
  const submitBtn   = document.getElementById('tbAuditSubmitBtn');
  const urlLabel    = document.getElementById('tba-url-label');
  const urlInput    = document.getElementById('tba-url');
  const nameInput   = document.getElementById('tba-name');
  const phoneInput  = document.getElementById('tba-phone');
  const emailInput  = document.getElementById('tba-email');
  const budgetInput = document.getElementById('tba-budget');
  const hiddenName  = document.getElementById('tba-hidden-name');
  const hiddenComp  = document.getElementById('tba-hidden-company');
  const hiddenSvc   = document.getElementById('tba-hidden-service');
  const hiddenMsg   = document.getElementById('tba-hidden-message');
  const tsInput     = document.getElementById('tba-ts');

  const PRESETS = {
    'seo-audit': {
      badge: 'Free SEO Audit',
      title: 'Get Your Free SEO Audit',
      lead: 'Share your contact details and website URL — we will review your rankings, technical health, and quick wins.',
      service: 'Free SEO Audit',
      submit: 'Request Free SEO Audit',
      fields: ['phone', 'email', 'site_url'],
      required: ['phone', 'email', 'site_url'],
      urlLabel: 'Website URL *',
      urlPlaceholder: 'https://yourwebsite.com'
    },
    'ai-audit': {
      badge: 'Free AI Search Audit',
      title: 'Get Your Free AI Visibility Audit',
      lead: 'Find out how your brand shows up in ChatGPT, Perplexity, and Google AI Overviews.',
      service: 'Free AI SEO Audit',
      submit: 'Request Free AI Audit',
      fields: ['phone', 'email', 'site_url'],
      required: ['phone', 'email', 'site_url'],
      urlLabel: 'Website URL *',
      urlPlaceholder: 'https://yourwebsite.com'
    },
    'ad-audit': {
      badge: 'Free Ad Audit',
      title: 'Get Your Free Ad Account Audit',
      lead: 'We will review your Google & Meta ad potential and highlight wasted spend and ROI opportunities.',
      service: 'Free Ad Audit',
      submit: 'Request Free Ad Audit',
      fields: ['phone', 'email', 'site_url', 'budget'],
      required: ['phone', 'email', 'site_url'],
      urlLabel: 'Website or Landing Page URL *',
      urlPlaceholder: 'https://yourwebsite.com'
    },
    'smm-audit': {
      badge: 'Free Social Media Audit',
      title: 'Get Your Free Social Media Audit',
      lead: 'Share your social profile or website URL and we will highlight content and audience growth opportunities.',
      service: 'Free Social Media Audit',
      submit: 'Request Free Social Audit',
      fields: ['phone', 'email', 'site_url'],
      required: ['phone', 'email', 'site_url'],
      urlLabel: 'Website or Social Handle URL *',
      urlPlaceholder: 'https://instagram.com/yourbrand or https://yourwebsite.com'
    },
    'lead-audit': {
      badge: 'Free Lead Gen Audit',
      title: 'Get Your Free Lead Generation Audit',
      lead: 'Share your website and contact details to receive a tailored funnel and acquisition review.',
      service: 'Free Lead Generation Audit',
      submit: 'Request Free Lead Audit',
      fields: ['phone', 'email', 'site_url'],
      required: ['phone', 'email', 'site_url'],
      urlLabel: 'Website URL *',
      urlPlaceholder: 'https://yourwebsite.com'
    },
    'web-project': {
      badge: 'Website Consultation',
      title: 'Start Your Website Project',
      lead: 'Share your details and we will follow up with a clear scope, timeline, and estimate.',
      service: 'Website Development Consultation',
      submit: 'Request Website Consultation',
      fields: ['name', 'phone', 'email', 'site_url'],
      required: ['name', 'phone', 'email'],
      urlLabel: 'Current Website URL (optional)',
      urlPlaceholder: 'https://yourwebsite.com (if you have one)'
    },
    'real-estate': {
      badge: 'Real Estate Growth Plan',
      title: 'Request a Real Estate Marketing Plan',
      lead: 'Tell us where to reach you and our specialists will prepare a buyer-lead strategy for your project.',
      service: 'Real Estate Marketing',
      submit: 'Request Marketing Plan',
      fields: ['name', 'phone', 'email', 'site_url'],
      required: ['name', 'phone', 'email'],
      urlLabel: 'Project or Company Website (optional)',
      urlPlaceholder: 'https://yourproject.com'
    },
    'free-audit': {
      badge: 'Free Digital Audit',
      title: 'Get Your Free Digital Marketing Audit',
      lead: 'Share your contact details and website URL for a no-obligation visibility review.',
      service: 'Free Digital Marketing Audit',
      submit: 'Request Free Audit',
      fields: ['phone', 'email', 'site_url'],
      required: ['phone', 'email', 'site_url'],
      urlLabel: 'Website URL *',
      urlPlaceholder: 'https://yourwebsite.com'
    }
  };

  let activePreset = PRESETS['seo-audit'];

  function openAuditModal(presetKey, customTitle) {
    activePreset = PRESETS[presetKey] || PRESETS['free-audit'];
    if (badgeText) badgeText.textContent = activePreset.badge;
    if (titleEl) titleEl.textContent = customTitle || activePreset.title;
    if (leadEl) leadEl.textContent = activePreset.lead;
    if (submitBtn) submitBtn.textContent = activePreset.submit;
    if (hiddenSvc) hiddenSvc.value = activePreset.service;
    if (urlLabel && activePreset.urlLabel) urlLabel.textContent = activePreset.urlLabel;
    if (urlInput && activePreset.urlPlaceholder) urlInput.placeholder = activePreset.urlPlaceholder;

    modal.querySelectorAll('[data-audit-field]').forEach(function (wrap) {
      const key = wrap.getAttribute('data-audit-field');
      const show = activePreset.fields.indexOf(key) !== -1;
      wrap.hidden = !show;
      const input = wrap.querySelector('input, select, textarea');
      if (input) {
        input.required = show && activePreset.required.indexOf(key) !== -1;
        input.disabled = !show;
      }
    });

    if (statusEl) {
      statusEl.className = 'tb-call-form__status';
      statusEl.textContent = '';
    }
    if (tsInput) tsInput.value = String(Math.floor(Date.now() / 1000));

    modal.hidden = false;
    document.body.style.overflow = 'hidden';

    const firstVisible = modal.querySelector('[data-audit-field]:not([hidden]) input');
    if (firstVisible) setTimeout(function () { firstVisible.focus(); }, 80);
  }

  function closeAuditModal() {
    modal.hidden = true;
    document.body.style.overflow = '';
  }

  document.addEventListener('click', function (e) {
    const trigger = e.target.closest('[data-audit-modal]');
    if (trigger) {
      e.preventDefault();
      openAuditModal(
        trigger.getAttribute('data-audit-modal'),
        trigger.getAttribute('data-modal-title') || ''
      );
      return;
    }
    if (e.target.closest('[data-close-audit-modal]')) {
      closeAuditModal();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.hidden) {
      closeAuditModal();
    }
  });

  if (form && statusEl) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const emailVal  = emailInput ? emailInput.value.trim() : '';
      const phoneVal  = phoneInput ? phoneInput.value.trim() : '';
      const urlVal    = urlInput && !urlInput.disabled ? urlInput.value.trim() : '';
      const nameVal   = nameInput && !nameInput.disabled ? nameInput.value.trim() : '';
      const budgetVal = budgetInput && !budgetInput.disabled ? budgetInput.value.trim() : '';

      const fallbackName = nameVal || (emailVal.split('@')[0] || 'Website Visitor').replace(/[._-]+/g, ' ').trim();
      if (hiddenName) hiddenName.value = fallbackName.length >= 2 ? fallbackName : 'Audit Lead';
      if (hiddenComp) hiddenComp.value = urlVal || 'Website Enquiry';

      const msgLines = [
        'Request Type: ' + (activePreset.service || 'Free Audit'),
        'Page: ' + window.location.pathname
      ];
      if (urlVal) msgLines.push('Website URL: ' + urlVal);
      if (phoneVal) msgLines.push('Contact Number: ' + phoneVal);
      if (budgetVal) msgLines.push('Monthly Ad Budget: ' + budgetVal);
      if (hiddenMsg) hiddenMsg.value = msgLines.join('\n');

      if (submitBtn) submitBtn.disabled = true;
      statusEl.className = 'tb-call-form__status';
      statusEl.textContent = 'Submitting your request...';

      const getToken = (typeof window.tbGetRecaptchaToken === 'function')
        ? window.tbGetRecaptchaToken('audit_modal')
        : Promise.resolve('');

      getToken.then(function (token) {
        const tokenEl = document.getElementById('tba-recaptcha-token');
        if (tokenEl) tokenEl.value = token || '';
        return fetch(form.getAttribute('action'), {
          method: 'POST',
          body: new FormData(form)
        });
      })
        .then(function (r) {
          return r.json().catch(function () { return { ok: false, message: 'Unexpected server response.' }; });
        })
        .then(function (data) {
          if (!data || !data.ok) {
            throw new Error((data && data.message) || 'Could not submit your request. Please call +91 86064 97677.');
          }
          form.reset();
          statusEl.className = 'tb-call-form__status is-ok';
          statusEl.textContent = 'Thank you! Your ' + activePreset.service.toLowerCase() + ' request has been received. Our team will reach out within one working day.';
        })
        .catch(function (err) {
          statusEl.className = 'tb-call-form__status is-err';
          statusEl.textContent = (err && err.message) ? err.message : 'Could not send right now. Please call +91 86064 97677.';
        })
        .finally(function () {
          if (submitBtn) submitBtn.disabled = false;
        });
    });
  }
})();

/* ===== Back to Top Button ===== */
(function () {
  const btn = document.getElementById('tbBackToTop');
  if (!btn) return;

  function toggleVisibility() {
    const show = (window.scrollY || window.pageYOffset || 0) > 320;
    btn.classList.toggle('is-visible', show);
  }

  window.addEventListener('scroll', toggleVisibility, { passive: true });
  toggleVisibility();

  btn.addEventListener('click', function () {
    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    window.scrollTo({
      top: 0,
      behavior: prefersReduced ? 'auto' : 'smooth'
    });
  });
})();



