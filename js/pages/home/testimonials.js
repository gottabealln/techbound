/* ===== TECHBOUND STAGGERED TESTIMONIAL BANNER ===== */

document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector(".testimonials");
  const topRow = document.querySelector(".testimonial-row--top");
  const bottomRow = document.querySelector(".testimonial-row--bottom");

  if (!section || !topRow || !bottomRow) {
    console.warn("Testimonial elements not found.");
    return;
  }

  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

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

    // Activate the top row only after further scrolling.
    const progress =
      (window.innerHeight - rect.top) / (window.innerHeight * 0.8);

    topStarted = progress >= 0.65;

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

    const topPaused = isHovering(topRow);
    const bottomPaused = isHovering(bottomRow);

    // BOTTOM ROW: moves unless the mouse is over it.
    if (bottomDistance > 0 && !bottomPaused) {
      bottomPosition =
        (bottomPosition + BOTTOM_SPEED * delta) % bottomDistance;

      bottomRow.style.transform =
        `translate3d(${-bottomDistance + bottomPosition}px, 0, 0)`;
    }

    // TOP ROW: fixed until the user scrolls farther, then moves unless hovered.
    if (!topStarted) {
      topRow.style.transform = "translate3d(0, 0, 0)";
    } else if (topDistance > 0 && !topPaused) {
      topPosition = (topPosition + TOP_SPEED * delta) % topDistance;

      topRow.style.transform =
        `translate3d(${-topDistance + topPosition}px, 0, 0)`;
    }

    frame = requestAnimationFrame(animate);
  }

  window.addEventListener("scroll", updateScroll, { passive: true });

  window.addEventListener("resize", () => {
    measureRows();
    updateScroll();
  });

  reducedMotion.addEventListener("change", updateScroll);

  measureRows();
  updateScroll();
});