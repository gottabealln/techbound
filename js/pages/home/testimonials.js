/* ===== TECHBOUND STAGGERED TESTIMONIAL BANNER ===== */

document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector(".testimonials");
  const topRow = document.querySelector(".testimonial-row--top");
  const bottomRow = document.querySelector(".testimonial-row--bottom");

  if (!section || !topRow || !bottomRow) {
    return;
  }

  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

  // Add "Read more" button to any card whose quote exceeds 2 lines (before cloning)
  [topRow, bottomRow].forEach((row) => {
    [...row.children].forEach((card) => {
      const p = card.querySelector(":scope > p");
      if (!p || card.querySelector(".testimonial-card__more")) return;
      if (p.scrollHeight > p.clientHeight + 2) {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "testimonial-card__more";
        btn.setAttribute("aria-expanded", "false");
        btn.textContent = "Read more";
        p.insertAdjacentElement("afterend", btn);
      }
    });
  });

  // Duplicate cards for seamless horizontal looping.
  [topRow, bottomRow].forEach((row) => {
    if (row.dataset.cloned === "true") return;

    [...row.children].forEach((card) => {
      const clone = card.cloneNode(true);
      clone.setAttribute("aria-hidden", "true");
      row.appendChild(clone);
    });

    row.dataset.cloned = "true";
  });

  // Expand / collapse quote on "Read more" click
  section.addEventListener("click", (e) => {
    const btn = e.target.closest(".testimonial-card__more");
    if (!btn) return;
    const card = btn.closest(".testimonial-card");
    if (!card) return;
    const expanded = card.classList.toggle("is-expanded");
    btn.setAttribute("aria-expanded", expanded ? "true" : "false");
    btn.textContent = expanded ? "Show less" : "Read more";
  });

  let topPosition = 0;
  let bottomPosition = 0;
  let topDistance = 0;
  let bottomDistance = 0;
  let topStarted = false;
  let sectionActive = false;
  let lastTime = 0;
  let frame = null;

  // Pointer tracking (mouse only)
  let pointerY = null;

  const TOP_SPEED = 35;
  const BOTTOM_SPEED = 45;

  function measureRows() {
    topDistance = topRow.scrollWidth / 2;
    bottomDistance = bottomRow.scrollWidth / 2;
  }

  // Is the mouse vertically inside this row?
  function isHovering(row) {
    if (pointerY === null) return false;
    const r = row.getBoundingClientRect();
    return pointerY >= r.top && pointerY <= r.bottom;
  }

  section.addEventListener("pointermove", (e) => {
    if (e.pointerType !== "mouse") return;
    pointerY = e.clientY;
  });

  section.addEventListener("pointerleave", () => {
    pointerY = null;
  });

  function updateScroll() {
    const rect = section.getBoundingClientRect();

    sectionActive = rect.top < window.innerHeight && rect.bottom > 0;

    // Activate the top row smoothly once scrolled into view.
    const progress =
      (window.innerHeight - rect.top) / (window.innerHeight * 0.8);

    topStarted = progress >= 0.2;

    if (sectionActive && !reducedMotion.matches) {
      if (frame === null) {
        lastTime = 0;
        frame = requestAnimationFrame(animate);
      }
    } else {
      if (frame !== null) {
        cancelAnimationFrame(frame);
        frame = null;
      }
      lastTime = 0;
    }
  }

  function animate(time) {
    frame = null;

    if (!sectionActive || reducedMotion.matches) return;

    if (!lastTime) lastTime = time;

    const delta = Math.min((time - lastTime) / 1000, 0.05);
    lastTime = time;

    const topPaused = isHovering(topRow) || !!topRow.querySelector(".testimonial-card.is-expanded");
    const bottomPaused = isHovering(bottomRow) || !!bottomRow.querySelector(".testimonial-card.is-expanded");

    // BOTTOM ROW: slides left unless hovered or expanded.
    if (bottomDistance > 0 && !bottomPaused) {
      bottomPosition =
        (bottomPosition + BOTTOM_SPEED * delta) % bottomDistance;

      bottomRow.style.transform =
        `translateX(${-bottomPosition}px)`;
    }

    // TOP ROW: slides right unless hovered or expanded.
    if (topDistance > 0 && !topPaused) {
      topPosition = (topPosition + TOP_SPEED * delta) % topDistance;

      topRow.style.transform =
        `translateX(${-topDistance + topPosition}px)`;
    }

    frame = requestAnimationFrame(animate);
  }

  window.addEventListener("scroll", updateScroll, { passive: true });

  window.addEventListener("resize", () => {
    measureRows();
    updateScroll();
  });

  window.addEventListener("orientationchange", () => {
    setTimeout(() => {
      measureRows();
      updateScroll();
    }, 150);
  });

  window.addEventListener("load", () => {
    measureRows();
    updateScroll();
  });

  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(() => {
      measureRows();
      updateScroll();
    });
  }

  reducedMotion.addEventListener("change", updateScroll);

  measureRows();
  updateScroll();
});
