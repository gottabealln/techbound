<?php
$page_title   = 'SEO Company in Trivandrum, Kerala | TechBound';
$page_desc    = 'Rank higher on Google and drive qualified organic traffic with TechBound, a premier SEO company in Trivandrum, Kerala. Technical SEO, local search, and content strategy.';
$page_styles = ['css/seo.css'];
include __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero hero--inner" style="background-image: url('<?= asset('assets/services/seo-hero-1.jpg') ?>');">
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <div class="hero__tagline-wrap">
      <nav class="hero__crumbs" aria-label="Breadcrumb">
        <a href="<?= url('index.php') ?>">Home</a><span>/</span>
        <a href="<?= url('services.php') ?>">Services</a><span>/</span>
        <span class="is-current">SEO</span>
      </nav>
      <div class="hero__line"></div>
    </div>

    <div class="hero__body">
      <div class="hero__text">
        <h1 class="hero__title">Search Engine Optimization</h1>
        <p class="hero__desc">
          Your customers are already searching. We build the search visibility that puts your business in front of them, in Trivandrum, across Kerala and beyond.
        </p>
      </div>

      <div class="hero__buttons">
        <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow">Get a Free SEO Audit</a>
        <a href="#process" class="btn btn--outline btn--arrow">See Our Process</a>
      </div>
    </div>
  </div>
</section>

<section class="svc-section svc-section--tint">
  <div class="svc-wrap svc-incl">
    <div>
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        What's included
      </span>
      <h2 class="svc-title">SEO that covers every way people find you</h2>
      <p class="svc-text" style="margin-top:18px">
        Ranking is not one trick. We work on the site, the content and the signals around it,
        and report on what actually brings enquiries.
      </p>
    </div>
    <ul class="svc-incl__list">
      <li>
        <span class="svc-incl__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></span>
        <div><h3>Keyword research</h3><p>The searches your buyers really use, ranked by intent and by how winnable they are.</p></div>
      </li>
      <li>
        <span class="svc-incl__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 6h16M4 12h10M4 18h7"/></svg></span>
        <div><h3>On-page SEO</h3><p>Titles, headings, content and internal links tuned page by page.</p></div>
      </li>
      <li>
        <span class="svc-incl__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 4 14h7l-1 8 9-12h-7z"/></svg></span>
        <div><h3>Technical SEO</h3><p>Speed, mobile experience, crawling, indexing and structured data, fixed at the source.</p></div>
      </li>
      <li>
        <span class="svc-incl__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
        <div><h3>Local SEO</h3><p>Google Business Profile, map rankings and local listings for customers nearby.</p></div>
      </li>
      <li>
        <span class="svc-incl__icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/></svg></span>
        <div><h3>Link building</h3><p>Relevant, earned links from sites your audience already trusts.</p></div>
      </li>
    </ul>
  </div>
</section>

<section class="svc-section" id="process">
  <div class="svc-wrap">
    <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        How we work
      </span>
    <h2 class="svc-title">From audit to monthly results</h2>
    <ol class="svc-steps">
      <li><h3>Audit</h3><p>We review your site, competitors and current rankings to find the gaps.</p></li>
      <li><h3>Strategy</h3><p>A priority plan: which pages to build, fix or merge, and in what order.</p></li>
      <li><h3>Execution</h3><p>On-page, technical and content work, shipped in steady monthly cycles.</p></li>
      <li><h3>Reporting</h3><p>Plain monthly reports on rankings, traffic and enquiries, with next steps.</p></li>
    </ol>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="faq" id="faq" data-nav="light">
  <div class="faq__inner">
    <h2 class="faq__title">Frequently Asked Questions</h2>

    <div class="faq__list">
      <div class="faq__item is-open">
        <h3>
          <button class="faq__question" type="button" aria-expanded="true" aria-controls="faq-1">
            1. How long does SEO take to show results?
          </button>
        </h3>
        <div class="faq__answer" id="faq-1">
          <div class="faq__answer-inner">
            <p>Most sites see early movement in two to three months, with steadier gains from month four or five. It depends on competition, your site's current state and how fast fixes go live.</p>
          </div>
        </div>
      </div>

      <div class="faq__item">
        <h3>
          <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-2">
            2. Do you guarantee a number one ranking?
          </button>
        </h3>
        <div class="faq__answer" id="faq-2">
          <div class="faq__answer-inner">
            <p>No one can honestly promise that. We commit to the work, a clear plan and transparent reporting on rankings, traffic and enquiries.</p>
          </div>
        </div>
      </div>

      <div class="faq__item">
        <h3>
          <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-3">
            3. Can you help a business that only serves Kerala?
          </button>
        </h3>
        <div class="faq__answer" id="faq-3">
          <div class="faq__answer-inner">
            <p>Yes. Local SEO is part of the service: Google Business Profile, map rankings and location pages for the areas you serve.</p>
          </div>
        </div>
      </div>

      <div class="faq__item">
        <h3>
          <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-4">
            4. What do you need from us to start?
          </button>
        </h3>
        <div class="faq__answer" id="faq-4">
          <div class="faq__answer-inner">
            <p>Access to your website and Google Search Console and Analytics if you have them, plus a short call about your services and target customers.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="svc-cta">
  <h2>Ready to be found on Google?</h2>
  <p>Tell us about your business and we'll send a free SEO audit with the first things to fix.</p>
  <a class="btn-outline" href="<?= url('contact.php') ?>">Get a free SEO audit
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
  </a>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>