<?php
$page_title = 'AI SEO, AEO & GEO Services in Kerala | TechBound';
$page_desc  = 'Get your business cited by Google AI Overviews, ChatGPT, Gemini and Perplexity. Expert Answer Engine and Generative Engine Optimization from Trivandrum.';
$page_styles = ['css/seo.css'];
$page_scripts = ['js/pages/home/process.js'];

// Fetch FAQs safely (with graceful fallback if DB is not configured on remote hosting)
$faqs = [];
try {
  require_once __DIR__ . '/includes/db.php';
  $stmt = db()->query("SELECT * FROM faqs WHERE active = 1 ORDER BY sort_order ASC LIMIT 6");
  $faqs = $stmt ? $stmt->fetchAll() : [];
} catch (Throwable $e) {
  $faqs = [];
}

include __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero hero--inner" style="background-image: url('<?= asset('assets/services/ai-seo-hero-2.jpg') ?>');">
  <div class="hero__overlay"></div>
  
  <div class="hero__content">
    <div class="hero__tagline-wrap">
      <nav class="hero__crumbs" aria-label="Breadcrumb">
        <a href="<?= url('index.php') ?>">Home</a><span>/</span>
        <a href="<?= url('services.php') ?>">Services</a><span>/</span>
        <span class="is-current">AI SEO</span>
      </nav>
      <div class="hero__line"></div>
    </div>

    <div class="hero__body">
      <div class="hero__text">
        <h1 class="hero__title">AI SEO, AEO &amp; GEO Services in Kerala</h1>
        <p class="hero__desc">
          Get your business understood, cited and recommended when customers ask Google AI Overviews, ChatGPT, Gemini or Perplexity who to trust. Built on 15+ years of search expertise.
        </p>
      </div>

      <div class="hero__buttons">
        <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow" data-audit-modal="ai-audit">Get Free AI Audit</a>
        <a href="#process" class="btn btn--outline btn--arrow">See Our Process</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== STATS ===== -->
<section class="svc-section py-5">
  <div class="container">
    <div class="row g-4 justify-content-center text-center">
      <div class="col-12 col-md-4">
        <div class="ai-stat">
          <div class="ai-stat__num display-5 fw-bold mb-1"><span data-count="2009">2009</span></div>
          <div class="ai-stat__label text-muted fs-6 fw-medium">Founded in Trivandrum</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="ai-stat">
          <div class="ai-stat__num display-5 fw-bold mb-1"><span data-count="15">15</span><sup>+</sup></div>
          <div class="ai-stat__label text-muted fs-6 fw-medium">Years in search</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="ai-stat">
          <div class="ai-stat__num display-5 fw-bold mb-1"><span data-count="6">6</span><sup>+</sup></div>
          <div class="ai-stat__label text-muted fs-6 fw-medium">Countries served</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHY THIS MATTERS ===== -->
<section class="svc-section">
  <div class="svc-wrap svc-center">
    <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        The Shift
      </span>
    <h2 class="svc-title">Why this matters now</h2>
    <p class="svc-text">The way people search is changing. AI tools are answering questions before users ever click a traditional link.</p>
    
    <div class="ai-features" style="text-align: left; max-width: 900px; margin: 40px auto 0;">
      <div class="ai-feature">
        <h3>8% vs 15%</h3>
        <p>Share of Google searches where users clicked a result when an AI summary appeared, compared with searches without one. <br><em>Source: Pew Research Center, 2025</em></p>
      </div>
      <div class="ai-feature">
        <h3>100M+</h3>
        <p>Monthly users of Google AI Mode across the US and India, as reported by Google in July 2025. <br><em>Source: Google via TechCrunch</em></p>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHAT'S INCLUDED ===== -->
<section class="svc-section svc-section--tint">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 40px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        What's included
      </span>
      <h2 class="svc-title">Be the business AI answers name, not the one they skip</h2>
      <p class="svc-text" style="margin: 18px auto 0;">AI SEO combines classic SEO for rankings, answer engine optimization (AEO) for direct answers, and generative engine optimization (GEO) for mentions inside AI responses.</p>
    </div>
    
    <div class="ai-features">
      <div class="ai-feature">
        <h3>AI Visibility Audit</h3>
        <p>A baseline of how often ChatGPT, Gemini, Perplexity and Google AI Overviews mention you for your buyers' questions, and which competitors they name instead.</p>
      </div>
      <div class="ai-feature">
        <h3>Answer Engine Optimization (AEO)</h3>
        <p>Question-led headings with a direct 40–60 word answer beneath, built for featured snippets, People Also Ask and AI Overviews.</p>
      </div>
      <div class="ai-feature">
        <h3>Generative Engine Optimization (GEO)</h3>
        <p>Content with specific, sourced facts that language models can quote, plus the outside mentions that make those facts believable.</p>
      </div>
      <div class="ai-feature">
        <h3>Entity & Brand Consistency</h3>
        <p>Your name, address, services and description kept identical across your website, Google Business Profile and directories, so AI tools describe you accurately.</p>
      </div>
      <div class="ai-feature">
        <h3>Structured Data</h3>
        <p>Organization, LocalBusiness, Service, Article and FAQPage schema in JSON-LD, describing only what visitors can actually see.</p>
      </div>
      <div class="ai-feature">
        <h3>AI Crawler Access</h3>
        <p>robots.txt rules that name the retrieval bots behind AI answers, such as OAI-SearchBot and PerplexityBot, and key content rendered in plain HTML.</p>
      </div>
      <div class="ai-feature">
        <h3>Local AI Visibility</h3>
        <p>Google Business Profile, reviews and local pages for Trivandrum, Kochi and other Kerala markets, so "near me" questions in AI tools can find you.</p>
      </div>
      <div class="ai-feature">
        <h3>Monthly AI Reporting</h3>
        <p>Citations per AI platform, Google rankings, AI-referred visits and leads, shown together in one plain-language report.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== PROCESS ===== -->
<section class="svc-section process" id="process">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 50px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Process
      </span>
      <h2 class="svc-title">Our generative engine optimization process</h2>
      <p class="svc-text" style="margin: 18px auto 0;">Discovery takes 2–3 weeks and implementation 4–6 weeks. Early signals usually appear around weeks 8–12, with mature results in 4–6 months.</p>
    </div>
    
    <!-- Timeline matching index.php -->
    <div class="process__timeline" id="processTimeline">
      <div class="process__line"><div class="process__fill" id="processFill"></div></div>
      <span class="process__dot" id="processDot"></span>

      <!-- Step 1 -->
      <div class="process__step process__step--left">
        <div class="process__content">
          <span class="process__num">01</span>
          <h3>Set your baseline</h3>
          <p>We agree on 20-30 real questions your buyers ask, run them through all AI platforms, and record who is cited.</p>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="process__step process__step--right">
        <div class="process__content">
          <span class="process__num">02</span>
          <h3>Open access for crawlers</h3>
          <p>We check robots.txt, rendering, and sitemaps so the bots that fetch pages for AI answers can read your content.</p>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="process__step process__step--left">
        <div class="process__content">
          <span class="process__num">03</span>
          <h3>Clean up your entity</h3>
          <p>We make your business details consistent everywhere and add structured data so AI tools know exactly who you are.</p>
        </div>
      </div>

      <!-- Step 4 -->
      <div class="process__step process__step--right">
        <div class="process__content">
          <span class="process__num">04</span>
          <h3>Rewrite pages answer-first</h3>
          <p>Your most important service pages get direct answers, FAQ blocks and comparison tables written by industry experts.</p>
        </div>
      </div>

      <!-- Step 5 -->
      <div class="process__step process__step--left">
        <div class="process__content">
          <span class="process__num">05</span>
          <h3>Build proof &amp; mentions</h3>
          <p>We turn your results into case studies, grow genuine reviews and earn mentions on publications AI tools read.</p>
        </div>
      </div>

      <!-- Step 6 -->
      <div class="process__step process__step--right">
        <div class="process__content">
          <span class="process__num">06</span>
          <h3>Measure &amp; refine</h3>
          <p>We re-run your question set, compare against competitors and adjust the plan. If something isn't moving, we change the approach.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== PRICING ===== -->
<section class="svc-section svc-section--tint">
  <div class="svc-wrap svc-center">
    <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Packages
      </span>
    <h2 class="svc-title">AI SEO packages and pricing</h2>
    <p class="svc-text" style="margin: 18px auto 0;">Cost depends on site size, competition and how many AI platforms you want tracked. Every quote is fixed before work starts.</p>
    
    <div class="pricing-grid" style="text-align: left;">
      <div class="pricing-card">
        <h3>AI Visibility Audit</h3>
        <div class="price">Custom Quote</div>
        <ul>
          <li>One-time baseline</li>
          <li>Competitor gap report</li>
          <li>90-day roadmap</li>
          <li>Yours to keep</li>
        </ul>
        <a href="<?= url('contact.php') ?>" class="btn-outline" data-audit-modal="ai-audit" style="color: #0a1220; border-color: #0a1220; text-align: center; justify-content: center;">Enquire Now</a>
      </div>
      <div class="pricing-card pricing-card--highlight">
        <h3>AI SEO Retainer</h3>
        <div class="price">Monthly Plan</div>
        <ul>
          <li>SEO, AEO and GEO as one</li>
          <li>Technical fixes</li>
          <li>Entity work & mentions</li>
          <li>Monthly reporting</li>
        </ul>
        <a href="<?= url('contact.php') ?>" class="btn-outline" data-audit-modal="ai-audit" style="background: var(--brand); color: #fff; border-color: var(--brand); text-align: center; justify-content: center;">Get Started</a>
      </div>
      <div class="pricing-card">
        <h3>Add-on for SEO Clients</h3>
        <div class="price">Add-on</div>
        <ul>
          <li>Layer AEO & GEO</li>
          <li>Onto current SEO plan</li>
          <li>AI citation tracking</li>
          <li>Added to your report</li>
        </ul>
        <a href="<?= url('contact.php') ?>" class="btn-outline" data-audit-modal="ai-audit" style="color: #0a1220; border-color: #0a1220; text-align: center; justify-content: center;">Enquire Now</a>
      </div>
    </div>
  </div>
</section>

<?php
$faq_page  = 'ai-seo';
$faq_title = 'Frequently Asked Questions';
require __DIR__ . '/includes/faq-section.php';
?>

<!-- ===== CTA ===== -->
<section class="svc-cta">
  <h2>Be the business AI answers name.</h2>
  <p>Talk to us about your AI visibility. We'll show you where you stand and what to fix first.</p>
  <a class="btn-outline" href="<?= url('contact.php') ?>" data-audit-modal="ai-audit">Get your free AI audit
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
  </a>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>