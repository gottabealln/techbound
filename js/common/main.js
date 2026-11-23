
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


