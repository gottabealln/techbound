<?php
$page_title   = 'Portfolio | TechBound Digital Marketing Agency in Trivandrum';
$page_desc    = 'Explore TechBound\'s portfolio of SEO, AI search, paid advertising, social media marketing, and high-converting web development projects across Kerala, India, and the GCC.';
$header_light = false;
$page_styles  = ['css/portfolio.css'];
$page_scripts = ['js/pages/home/counter.js'];
$page_slug    = 'portfolio';

$projects = [
  [
    'title'    => 'Luxury Villa & Commercial Builder Growth System',
    'cat'      => 'seo',
    'catLabel' => 'SEO & AI Search',
    'industry' => 'Construction & Real Estate',
    'metric'   => '+240% Organic Leads',
    'image'    => 'assets/portfolio/villa-builder.jpg',
    'summary'  => 'Rebuilt local SEO architecture, Google Business Profile authority, and high-intent project pages to capture NRI and Kerala villa buyers.',
    'tags'     => ['Local SEO', 'Technical SEO', 'Lead Funnel'],
  ],
  [
    'title'    => 'Multi-Specialty Clinic Appointment Engine',
    'cat'      => 'ads',
    'catLabel' => 'Paid Advertising',
    'industry' => 'Healthcare',
    'metric'   => '5.2x Return on Ad Spend',
    'image'    => 'assets/portfolio/clinic-healthcare.jpg',
    'summary'  => 'Full-funnel Google Search and Meta retargeting campaigns paired with WhatsApp booking flows that cut cost-per-booking by 42%.',
    'tags'     => ['Google Ads', 'Meta Ads', 'Conversion Tracking'],
  ],
  [
    'title'    => 'Study Abroad Consultancy High-Conversion Website',
    'cat'      => 'web',
    'catLabel' => 'Web Development',
    'industry' => 'Education',
    'metric'   => '3.4x Enquiry Rate',
    'image'    => 'assets/portfolio/study-abroad.jpg',
    'summary'  => 'Custom mobile-first website with country-wise course guides, fast Core Web Vitals, and multi-step counsellor enquiry forms.',
    'tags'     => ['Custom Web', 'UI/UX Design', 'Speed Optimisation'],
  ],
  [
    'title'    => 'D2C Lifestyle Brand Social & Performance Scale',
    'cat'      => 'social',
    'catLabel' => 'Social Media',
    'industry' => 'Ecommerce & Retail',
    'metric'   => '+310% Social Reach',
    'image'    => 'assets/portfolio/d2c-ecommerce.jpg',
    'summary'  => 'Cohesive short-form Reels calendar, creator collaborations, and catalog remarketing that turned social engagement into repeat online sales.',
    'tags'     => ['Content Strategy', 'Instagram Reels', 'Brand Growth'],
  ],
  [
    'title'    => 'AI Search & Generative Visibility Overhaul',
    'cat'      => 'seo',
    'catLabel' => 'SEO & AI Search',
    'industry' => 'B2B & SaaS',
    'metric'   => 'Top Citations in AI Answers',
    'image'    => 'assets/portfolio/b2b-analytics.jpg',
    'summary'  => 'Structured schema markup, topical authority hubs, and AEO/GEO content sprints earning recurring brand citations across Google AI Overviews and ChatGPT.',
    'tags'     => ['AI SEO', 'AEO & GEO', 'Schema Architecture'],
  ],
  [
    'title'    => 'Boutique Resort Direct Booking Experience',
    'cat'      => 'web',
    'catLabel' => 'Web Development',
    'industry' => 'Hospitality & Travel',
    'metric'   => '+185% Direct Bookings',
    'image'    => 'assets/portfolio/boutique-resort.jpg',
    'summary'  => 'Editorial visual storytelling, frictionless room availability flow, and seasonal Google Ads reducing reliance on third-party OTA commissions.',
    'tags'     => ['Web Design', 'Booking UX', 'Performance Ads'],
  ],
];

require __DIR__ . '/includes/header.php';
?>

<main>

  <!-- ===== HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/services.avif') ?>');" data-nav="dark">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">Portfolio</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Work That Delivers Measurable Business Growth</h1>
          <p class="hero__desc">
            Explore how we help businesses across Kerala, India, and the GCC attract quality leads, rank higher on Google and AI search, and convert more customers.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="#projects" class="btn btn--primary btn--arrow">Explore Projects</a>
          <a href="<?= url('contact.php') ?>" class="btn btn--outline btn--arrow">Start Your Project</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== IMPACT OVERVIEW (matches Home About section) ===== -->
  <section class="intro" data-nav="light">
    <div class="intro__inner">

      <div class="intro__left">
        <span class="pill pill--glow" data-animate="up">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Proven Track Record
        </span>
        <h2 class="intro__title" data-animate="up">Real Campaigns, Clear Numbers, Lasting Growth</h2>
        <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--sm btn--arrow">Book a Free Audit</a>
      </div>

      <div class="intro__right">
        <p class="intro__text" data-words>
          Every project at TechBound starts with your commercial goal. Whether it is qualified enquiries, search authority, or a faster website, we measure success by real business outcomes.
        </p>

        <div class="stats">
          <div class="stat">
            <div class="stat__num"><span data-count="290">290</span><sup>K+</sup></div>
            <p class="stat__label">Leads Generated</p>
          </div>
          <div class="stat">
            <div class="stat__num"><span data-count="94">94</span><sup>%</sup></div>
            <p class="stat__label">Client Retention</p>
          </div>
          <div class="stat">
            <div class="stat__num"><span data-count="5">5</span><sup>x</sup></div>
            <p class="stat__label">Avg. Paid ROAS</p>
          </div>
          <div class="stat">
            <div class="stat__num"><span data-count="18">18</span><sup>+</sup></div>
            <p class="stat__label">Industries Served</p>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ===== SELECTED WORK ===== -->
  <section class="services" id="projects" data-nav="light">
    <div class="services__inner">

      <div class="services__head">
        <span class="pill pill--glow" data-animate="up">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Our Portfolio
        </span>
        <div class="services__row">
          <h2 class="services__title" data-animate="up">Selected client work across search, ads &amp; web.</h2>
          <p class="services__lead" data-words>
            A look at the strategies, websites, and campaigns we have built to help ambitious businesses scale online.
          </p>
        </div>
      </div>

      <div class="pf-grid">
        <?php foreach ($projects as $p): ?>
          <article class="pf-card" data-cat="<?= htmlspecialchars($p['cat']) ?>" data-animate="up">
            <div class="pf-card__media">
              <img src="<?= asset($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
              <span class="pf-card__metric"><?= htmlspecialchars($p['metric']) ?></span>
            </div>
            <div class="pf-card__body">
              <div class="pf-card__meta">
                <span class="pf-card__cat"><?= htmlspecialchars($p['catLabel']) ?></span>
                <span><?= htmlspecialchars($p['industry']) ?></span>
              </div>
              <h3 class="pf-card__title"><?= htmlspecialchars($p['title']) ?></h3>
              <p class="pf-card__text"><?= htmlspecialchars($p['summary']) ?></p>
              <div class="pf-card__tags">
                <?php foreach ($p['tags'] as $tag): ?>
                  <span class="tag"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

  <!-- ===== INDUSTRIES WE SERVE ===== -->
  <section class="pf-industries" data-nav="light">
    <div class="pf-industries__inner">
      <div>
        <span class="pill pill--glow" data-animate="up">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Industries
        </span>
        <h2 class="pf-industries__title" data-animate="up">Experience Across Diverse Markets</h2>
        <p class="pf-industries__lead" data-words>
          We tailor every campaign to how your buyers research, compare, and decide — never a one-size-fits-all template.
        </p>
        <a href="<?= url('services.php') ?>" class="btn btn--primary btn--sm btn--arrow">Explore Our Services</a>
      </div>

      <div class="pf-industries__grid">
        <div class="pf-industry-chip" data-animate="up">Construction &amp; Real Estate</div>
        <div class="pf-industry-chip" data-animate="up">Healthcare &amp; Clinics</div>
        <div class="pf-industry-chip" data-animate="up">Education &amp; Study Abroad</div>
        <div class="pf-industry-chip" data-animate="up">Ecommerce &amp; D2C Retail</div>
        <div class="pf-industry-chip" data-animate="up">Hospitality &amp; Travel</div>
        <div class="pf-industry-chip" data-animate="up">B2B &amp; SaaS Companies</div>
        <div class="pf-industry-chip" data-animate="up">Local Service Brands</div>
        <div class="pf-industry-chip" data-animate="up">Manufacturing &amp; Exports</div>
      </div>
    </div>
  </section>

  <!-- ===== FAQ (matches site-wide .faq design) ===== -->
  <section class="faq" id="faq" data-nav="light">
    <div class="faq__inner">
      <h2 class="faq__title">Frequently Asked Questions</h2>

      <div class="faq__list">
        <div class="faq__item is-open">
          <h3>
            <button class="faq__question" type="button" aria-expanded="true" aria-controls="faq-1">
              1. Can you share detailed case studies relevant to my industry?
            </button>
          </h3>
          <div class="faq__answer" id="faq-1">
            <div class="faq__answer-inner">
              <p>Yes. During our discovery call, we walk you through live examples, ranking progressions, and campaign metrics from businesses in your sector or with similar sales cycles.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-2">
              2. Do you build websites and manage marketing together?
            </button>
          </h3>
          <div class="faq__answer" id="faq-2">
            <div class="faq__answer-inner">
              <p>Yes. Many of our strongest results come from pairing a conversion-focused website with SEO, Google Ads, Meta Ads, and social media so traffic lands on pages built to convert.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-3">
              3. How do you measure and report project results?
            </button>
          </h3>
          <div class="faq__answer" id="faq-3">
            <div class="faq__answer-inner">
              <p>We track concrete commercial metrics—qualified leads, calls, form submissions, organic rankings, and Return on Ad Spend (ROAS)—and share clear monthly reports with next-step actions.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-4">
              4. How quickly can we kick off a new project?
            </button>
          </h3>
          <div class="faq__answer" id="faq-4">
            <div class="faq__answer-inner">
              <p>Once we complete your initial audit and align on scope and timeline, we typically start discovery and setup within 3 to 5 working days.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== CTA BANNER (exact home-page .cta) ===== -->
  <section class="cta" data-nav="dark">
    <div class="cta__inner">
      <h2 class="cta__title">Ready to Be Our Next Success Story?</h2>
      <p class="cta__lead">
        Tell us about your goals and we'll share a practical roadmap tailored to your market, budget, and growth targets.
      </p>
      <div class="cta__actions">
        <a href="<?= url('contact.php') ?>" class="cta__btn cta__btn--solid">
          Book a Call
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
        <a href="<?= url('services.php') ?>" class="cta__btn cta__btn--ghost">Explore Services</a>
      </div>
    </div>
  </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
