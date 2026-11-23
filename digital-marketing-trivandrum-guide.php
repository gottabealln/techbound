<?php
$page_title   = 'Digital Marketing in Trivandrum: Complete Local Growth Guide | TechBound';
$page_desc    = 'A practical guide to digital marketing in Trivandrum, Kerala — covering local SEO, AI search, Google & Meta Ads, social media, and high-converting websites.';
$header_light = false;
$page_slug    = 'digital-marketing-trivandrum-guide';

require __DIR__ . '/includes/header.php';
?>

<main>

  <!-- ===== HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/hero.avif') ?>');" data-nav="dark">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">Digital Marketing in Trivandrum Guide</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Digital Marketing in Trivandrum: The Local Growth Guide</h1>
          <p class="hero__desc">
            Everything businesses in Thiruvananthapuram and Kerala need to know about ranking on Google, appearing in AI answers, running profitable ads, and converting local enquiries.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow">Get a Free Local Audit</a>
          <a href="<?= url('services.php') ?>" class="btn btn--outline btn--arrow">Explore Services</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== GUIDE PILLARS ===== -->
  <section class="services" data-nav="light">
    <div class="services__inner">

      <div class="services__head">
        <span class="pill pill--glow" data-animate="up">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Trivandrum Growth Playbook
        </span>
        <div class="services__row">
          <h2 class="services__title" data-animate="up">Core channels that drive enquiries in Trivandrum.</h2>
          <p class="services__lead" data-words>
            Build a predictable local acquisition system by combining search visibility, paid demand, and conversion-first web experiences.
          </p>
        </div>
      </div>

      <div class="services__grid">
        <article class="service-card" data-animate="up">
          <h3 class="service-card__title">Local SEO &amp; Google Maps</h3>
          <p class="service-card__text">Optimise your Google Business Profile, local service pages, and review velocity so buyers in Trivandrum find you first.</p>
          <div class="service-card__tags">
            <a href="<?= url('seo.php') ?>" class="tag">Explore SEO</a>
          </div>
        </article>

        <article class="service-card" data-animate="up">
          <h3 class="service-card__title">AI SEO, AEO &amp; GEO</h3>
          <p class="service-card__text">Structure your content and brand entities so Google AI Overviews, ChatGPT, and Perplexity cite your business directly.</p>
          <div class="service-card__tags">
            <a href="<?= url('ai-seo.php') ?>" class="tag">Explore AI SEO</a>
          </div>
        </article>

        <article class="service-card" data-animate="up">
          <h3 class="service-card__title">Google &amp; Meta Advertising</h3>
          <p class="service-card__text">Capture high-intent local searchers and retarget warm audiences across Instagram and Facebook with transparent ROAS tracking.</p>
          <div class="service-card__tags">
            <a href="<?= url('online-advertising.php') ?>" class="tag">Explore Paid Ads</a>
          </div>
        </article>

        <article class="service-card" data-animate="up">
          <h3 class="service-card__title">Social Media Marketing</h3>
          <p class="service-card__text">Build local trust and brand recall through consistent Reels, storytelling, and community management tailored for Kerala audiences.</p>
          <div class="service-card__tags">
            <a href="<?= url('smm.php') ?>" class="tag">Explore SMM</a>
          </div>
        </article>

        <article class="service-card" data-animate="up">
          <h3 class="service-card__title">Conversion-Focused Websites</h3>
          <p class="service-card__text">Fast, mobile-first websites engineered for Core Web Vitals, clear messaging, and frictionless WhatsApp and form enquiries.</p>
          <div class="service-card__tags">
            <a href="<?= url('website-development.php') ?>" class="tag">Explore Web Dev</a>
          </div>
        </article>

        <article class="service-card" data-animate="up">
          <h3 class="service-card__title">Full-Funnel Lead Generation</h3>
          <p class="service-card__text">Qualify prospects, automate follow-ups, and feed conversion data back into your ad platforms for steady pipeline growth.</p>
          <div class="service-card__tags">
            <a href="<?= url('lead-generation.php') ?>" class="tag">Explore Lead Gen</a>
          </div>
        </article>
      </div>

    </div>
  </section>

  <!-- ===== CTA BANNER ===== -->
  <section class="cta" data-nav="dark">
    <div class="cta__inner">
      <h2 class="cta__title">Ready to Grow Your Business in Trivandrum?</h2>
      <p class="cta__lead">
        Speak with our Trivandrum digital marketing specialists for a clear audit and custom growth roadmap.
      </p>
      <div class="cta__actions">
        <a href="<?= url('contact.php') ?>" class="cta__btn cta__btn--solid">
          Book a Call
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
        <?php /* <a href="<?= url('portfolio.php') ?>" class="cta__btn cta__btn--ghost">View Our Work</a> */ ?>
      </div>
    </div>
  </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
