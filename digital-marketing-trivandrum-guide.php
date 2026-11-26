<?php
$page_title   = 'Digital Marketing in Trivandrum: Services, Costs & 2026 Guide';
$page_desc    = 'Digital marketing in Trivandrum: SEO, AI search, social, ads and websites, what each costs and how fast it works. Get a free audit and quote from TechBound.';
$header_light = false;
$page_styles  = ['css/seo.css', 'css/guide.css'];
$page_slug    = 'digital-marketing-trivandrum-guide';

require __DIR__ . '/includes/header.php';

// Fetch latest 4 blog posts for the bottom blog showcase
$guide_posts = [];
try {
  require_once __DIR__ . '/includes/db.php';
  $stmt = db()->query("SELECT title, slug, category, image, published_at FROM blog_posts WHERE active = 1 ORDER BY published_at DESC, id DESC LIMIT 4");
  if ($stmt) {
    $guide_posts = $stmt->fetchAll();
  }
} catch (Throwable $e) {
  $guide_posts = [];
}
if (empty($guide_posts) && file_exists(__DIR__ . '/data/blogs_index.php')) {
  $all = require __DIR__ . '/data/blogs_index.php';
  if (is_array($all)) {
    $active = array_values(array_filter($all, fn($p) => ($p['active'] ?? 1) == 1));
    $guide_posts = array_slice($active, 0, 4);
  }
}
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
          <h1 class="hero__title">Digital Marketing in Trivandrum: The Complete Guide for Local Businesses</h1>
          <p class="hero__desc">
            More calls, enquiries and walk-ins from Google, Maps, social media and AI answers, planned and run by a Trivandrum team. Written by Shabna Nazeer, CTO at TechBound Innovations, who has run SEO, ads, social media and websites for Trivandrum businesses since 2009.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="#free-audit-form" data-audit-modal="free-audit" data-audit-title="Get Your Free Trivandrum Visibility Audit" class="btn btn--primary btn--arrow">Get My Free Audit</a>
          <a href="<?= url('services.php') ?>" class="btn btn--outline btn--arrow">See Our Services</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== PLATFORMS ===== -->
  <section class="svc-section guide-platforms" data-nav="light">
    <div class="svc-wrap guide-platforms__grid">
      <div class="guide-platforms__group" data-animate="up">
        <h2>We get Trivandrum businesses found on</h2>
        <p>Where buyers in Thiruvananthapuram search, compare and decide before calling.</p>
        <div class="guide-chips">
          <span>Google Search</span>
          <span>Google Maps</span>
          <span>AI Assistants</span>
          <span>YouTube</span>
          <span>Instagram</span>
        </div>
      </div>

      <div class="guide-platforms__group" data-animate="up" style="--d:100ms">
        <h2>Platforms we set up and manage for you</h2>
        <p>Every client gets these set up correctly from day one, so every enquiry can be tracked back to the channel that brought it.</p>
        <div class="guide-chips">
          <span>Google Ads</span>
          <span>Google Business Profile</span>
          <span>Google Analytics</span>
          <span>Google Search Console</span>
          <span>Meta Ads</span>
          <span>WhatsApp Business</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== HOW DIGITAL MARKETING HAS CHANGED ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Market Shifts
        </span>
        <h2 class="svc-title" data-words>How digital marketing in Trivandrum has changed</h2>
        <p class="svc-text">
          Three shifts that decide which business gets the enquiry in Thiruvananthapuram today, and what we do about each.
        </p>
      </div>

      <div class="guide-grid-3">
        <article class="guide-card" data-animate="up">
          <span class="guide-num">01</span>
          <h3>Buyers read AI answers first</h3>
          <p>
            In a March 2025 study of US Google users, Pew Research found people clicked a regular result in 8% of visits when an AI summary appeared, against 15% when none did. Google says there are no extra requirements or special schema to appear in AI Overviews: the same SEO fundamentals apply. So we run SEO, answer engine optimisation (AEO) and generative engine optimisation (GEO) as one programme.
          </p>
          <p class="guide-card__source">Sources: Pew Research Center, 22 July 2025; Google Search Central.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:100ms">
          <span class="guide-num">02</span>
          <h3>The city's economy is widening</h3>
          <p>
            Technopark, India's first IT park, now hosts about 490 IT companies. Vizhinjam International Seaport began commercial operations in December 2024 and started full export-import operations in August 2026. Government, healthcare, education and tourism add more buyers who research before they call, and more competitors chasing them.
          </p>
          <p class="guide-card__source">Sources: Technopark ecosystem deck; The Week, 17 Aug 2026; Drishti IAS.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:200ms">
          <span class="guide-num">03</span>
          <h3>Local search speaks local</h3>
          <p>
            People search by landmark and area, such as "near Statue" or "in Kazhakkoottam", and respond to English and Malayalam captions and Business Profile posts. A national template misses both.
          </p>
          <a href="<?= url('seo.php') ?>" class="guide-card__link">Explore Local SEO &rarr;</a>
        </article>
      </div>

      <div class="guide-callout" data-animate="up" style="--d:120ms">
        <h3>We will run your real customer questions through the major AI tools and show you who gets named today.</h3>
        <div class="guide-callout__actions">
          <a href="tel:+918606497677" class="guide-btn-dark">Call +91 86064 97677</a>
          <a href="#free-audit-form" data-audit-modal="free-audit" data-audit-title="Request Your Free Trivandrum Audit" class="btn btn--primary btn--arrow">Request a Free Audit</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== SERVICES FOR TRIVANDRUM BUSINESSES ===== -->
  <section class="svc-section" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Our Services
        </span>
        <h2 class="svc-title" data-words>Digital marketing services for Trivandrum businesses</h2>
        <p class="svc-text">
          Pick one service to start, or let us build a plan across all of them. One team, one plan, one monthly report.
        </p>
      </div>

      <div class="guide-grid-3">
        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>Search Engine Optimization</h3>
          <p>Technical fixes, service and area pages, local SEO and genuine link building so Trivandrum buyers find you before your competitors. Best for any business people search for. Results build over 3 to 6 months.</p>
          <a href="<?= url('seo.php') ?>" class="guide-card__link">Explore our SEO services &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>AI SEO: AEO and GEO</h3>
          <p>We make your business easier for Google AI Overviews, ChatGPT, Gemini and Perplexity to find, understand and cite, and track your AI visibility every month.</p>
          <a href="<?= url('ai-seo.php') ?>" class="guide-card__link">See how AI search optimisation works &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Social Media Management</h3>
          <p>Instagram, Facebook and LinkedIn content planned, designed and posted for you, with English and Malayalam captions where they work. Judged on enquiries, not likes.</p>
          <a href="<?= url('smm.php') ?>" class="guide-card__link">View social media management plans &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>Online Advertisement</h3>
          <p>Google and Meta campaigns that bring leads within days, managed against a cost-per-lead target and coordinated with SEO so you never bid against yourself.</p>
          <a href="<?= url('online-advertising.php') ?>" class="guide-card__link">Read about Google and Meta ads &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>Website Development</h3>
          <p>Fast, mobile-first websites that search engines and AI crawlers can read, with clear services, area pages and click-to-call and WhatsApp built in.</p>
          <a href="<?= url('website-development.php') ?>" class="guide-card__link">See website development &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Lead Generation</h3>
          <p>Campaigns, landing pages and follow-up that turn visits into qualified enquiries, judged on cost per lead and lead quality, not clicks.</p>
          <a href="<?= url('lead-generation.php') ?>" class="guide-card__link">Learn about lead generation &rarr;</a>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== WHY TRIVANDRUM BUSINESSES CHOOSE TECHBOUND + NUMBERS ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Why TechBound
        </span>
        <h2 class="svc-title" data-words>Why Trivandrum businesses choose TechBound</h2>
        <p class="svc-text">What you can check before you sign anything.</p>
      </div>

      <div class="guide-grid-3">
        <article class="guide-card" data-animate="up">
          <h3>Head office in Trivandrum</h3>
          <p>Our head office is opposite the Secretariat, with a technical wing at Technopark. Trivandrum is our home market, not a satellite office.</p>
          <a href="<?= url('about.php') ?>" class="guide-card__link">Meet the team &rarr;</a>
        </article>

        <article class="guide-card" data-animate="up" style="--d:80ms">
          <h3>A team, not a freelancer</h3>
          <p>Specialists in SEO, social, ads, content and web, with a dedicated contact who knows your business and backup when someone is away.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:160ms">
          <h3>Reporting tied to enquiries</h3>
          <p>Leads, cost per lead, Business Profile calls, conversion rate and AI-referred visits in one plain-language monthly report.</p>
        </article>

        <article class="guide-card" data-animate="up">
          <h3>Honest about limits</h3>
          <p>No guaranteed rankings or AI citations. If a channel is not paying back in 60 to 90 days, we change the approach.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:80ms">
          <h3>15+ years of search shifts</h3>
          <p>From the early days of search to AI answers, our method has stayed the same: understand the business first, then build.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:160ms">
          <h3>Local office, global clients</h3>
          <p>Many Trivandrum purchases are researched by family in the Gulf and beyond. With clients in 6+ countries, we target them as well as local buyers.</p>
        </article>
      </div>

      <div class="guide-stats" data-animate="up">
        <div class="guide-stat">
          <div class="guide-stat__num">2009</div>
          <div class="guide-stat__label">Serving businesses since</div>
        </div>
        <div class="guide-stat">
          <div class="guide-stat__num">15+</div>
          <div class="guide-stat__label">Years of experience</div>
        </div>
        <div class="guide-stat">
          <div class="guide-stat__num">6+</div>
          <div class="guide-stat__label">Countries served</div>
        </div>
        <div class="guide-stat">
          <div class="guide-stat__num">250+</div>
          <div class="guide-stat__label">Projects delivered</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== SEO, AEO AND GEO TABLE ===== -->
  <section class="svc-section" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Search Mix
        </span>
        <h2 class="svc-title" data-words>SEO, AEO and GEO: how they work together</h2>
        <p class="svc-text">Three names for overlapping work. You don't have to pick one; you need the right mix.</p>
      </div>

      <div class="guide-table-wrap" data-animate="up" style="--d:80ms">
        <table class="guide-table">
          <thead>
            <tr>
              <th>Focus</th>
              <th>SEO</th>
              <th>AEO</th>
              <th>GEO</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Goal</td>
              <td>Rank in the list of results</td>
              <td>Become the direct answer</td>
              <td>Get named inside AI-written answers</td>
            </tr>
            <tr>
              <td>Where it shows</td>
              <td>Google and Bing results, map pack</td>
              <td>Featured snippets, People Also Ask, AI Overviews, voice</td>
              <td>ChatGPT, Gemini, Perplexity, Copilot</td>
            </tr>
            <tr>
              <td>What it relies on</td>
              <td>Technical health, relevance, links</td>
              <td>Clear question-and-answer structure, schema</td>
              <td>Entity clarity, sourced facts, outside mentions</td>
            </tr>
            <tr>
              <td>What we report</td>
              <td>Rankings, clicks, leads</td>
              <td>Snippet and AI Overview appearances</td>
              <td>Citations per platform for a fixed question set</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===== HOW WE WORK WITH YOU ===== -->
  <section class="svc-section svc-section--tint" id="process" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Our Process
        </span>
        <h2 class="svc-title" data-words>How we work with you</h2>
        <p class="svc-text">From first call to consistent enquiries.</p>
      </div>

      <div class="guide-grid-4">
        <article class="guide-card" data-animate="up">
          <span class="guide-num">01</span>
          <span class="guide-step-time">Weeks 1 to 3</span>
          <h3>Free audit and plan</h3>
          <p>We study your business, competitors and current channels, then share a free audit, a plan and a fixed quote.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:80ms">
          <span class="guide-num">02</span>
          <span class="guide-step-time">Weeks 4 to 9</span>
          <h3>Build and launch</h3>
          <p>Fixes, content, campaigns and tracking go live, so every enquiry can be traced to its source.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:160ms">
          <span class="guide-num">03</span>
          <span class="guide-step-time">Weeks 8 to 12</span>
          <h3>First results</h3>
          <p>Early leads and ranking movement. We cut what does not work and put the budget behind what does.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:240ms">
          <span class="guide-num">04</span>
          <span class="guide-step-time">Months 4 to 6</span>
          <h3>Scale and grow</h3>
          <p>Systems tuned for consistent enquiries, with a monthly report and review call throughout.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== WHAT OUR CLIENTS SAY ===== -->
  <section class="svc-section" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Client Feedback
        </span>
        <h2 class="svc-title" data-words>What our clients say</h2>
      </div>

      <div class="seo-testimonials__grid">
        <blockquote class="seo-review-card" data-animate="up">
          <p class="seo-review-card__quote">
            "Regardless of how urgent our needs were, the TechBound team responded quickly and professionally. Anyone in need of marketing services should get in touch with them. They have long served as our marketing consultants. The team is always responsive, honest, and professional. Our website ranks have significantly improved as a result of TechBound Digital Marketing agency's advice."
          </p>
          <footer class="seo-review-card__author">
            <span class="seo-review-card__avatar" aria-hidden="true">ML</span>
            <strong>Mihila L</strong>
          </footer>
        </blockquote>

        <blockquote class="seo-review-card" data-animate="up" style="--d:80ms">
          <p class="seo-review-card__quote">
            "I adore this Digital Marketing Company. With their new and 'fresh' ideas, they have helped my company grow and expand. I've had nothing but positive experiences with their team members, and their customer service is excellent. I highly recommend TechBound Digital Marketing Agency, if you are looking for a company that is attentive to your business goals and needs."
          </p>
          <footer class="seo-review-card__author">
            <span class="seo-review-card__avatar" aria-hidden="true">SH</span>
            <strong>SM Hilur</strong>
          </footer>
        </blockquote>

        <blockquote class="seo-review-card" data-animate="up" style="--d:160ms">
          <p class="seo-review-card__quote">
            "Having had bad experiences with digital marketing agencies for many years, we have used TechBound Digital Marketing Agency since Feb 2022 and I have been extremely impressed by the work and results they have brought our company in a relatively short space of time. Would strongly recommend TechBound Digital Marketing Agency to anyone looking for a solid, reliable digital agency that can deliver results."
          </p>
          <footer class="seo-review-card__author">
            <span class="seo-review-card__avatar" aria-hidden="true">PA</span>
            <strong>Princy Antony</strong>
          </footer>
        </blockquote>
      </div>
    </div>
  </section>

  <!-- ===== INDUSTRIES & COSTS ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Local Sectors
        </span>
        <h2 class="svc-title" data-words>Industries we work with in Trivandrum</h2>
      </div>

      <div class="guide-grid-2">
        <article class="guide-card" data-animate="up">
          <h3>Real estate and builders</h3>
          <p>Project pages that rank for area searches, Meta ads aimed at local and NRI buyers, and tracking down to site-visit bookings.</p>
          <a href="<?= url('construction.php') ?>" class="guide-card__link">Read what grows a real estate business &rarr;</a>
        </article>

        <article class="guide-card" data-animate="up" style="--d:80ms">
          <h3>Healthcare and clinics</h3>
          <p>Google Business Profile, reviews and treatment pages that bring appointment enquiries, with accurate, compliant claims.</p>
          <a href="<?= url('lead-generation.php') ?>" class="guide-card__link">Explore healthcare lead generation &rarr;</a>
        </article>

        <article class="guide-card" data-animate="up">
          <h3>Ecommerce and D2C</h3>
          <p>Product SEO, Google Shopping and Instagram content, managed against return on ad spend.</p>
          <a href="<?= url('online-advertising.php') ?>" class="guide-card__link">Explore ecommerce advertising &rarr;</a>
        </article>

        <article class="guide-card" data-animate="up" style="--d:80ms">
          <h3>Education, B2B and IT</h3>
          <p>In-depth content, LinkedIn and case studies for institutions and Technopark firms whose buyers research for weeks.</p>
          <a href="#free-audit-form" data-audit-modal="free-audit" data-audit-title="Discuss Your Sector With TechBound" class="guide-card__link">Discuss your sector with us &rarr;</a>
        </article>
      </div>

      <div class="guide-callout" data-animate="up" style="--d:120ms">
        <div>
          <h3>What Digital Marketing Costs in Trivandrum</h3>
          <p class="svc-text" style="margin-top:10px; max-width:680px;">
            Cost depends on how many channels you need and how competitive your market is. Most clients start on one channel that can prove return, then expand. Every quote is fixed before work starts.
          </p>
        </div>
        <div class="guide-callout__actions">
          <a href="#free-audit-form" data-audit-modal="free-audit" data-audit-title="Get Your Free Trivandrum Visibility Audit" class="btn btn--primary btn--arrow">Get My Free Audit</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== FURTHER GUIDES ===== -->
  <section class="svc-section" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Resource Library
        </span>
        <h2 class="svc-title" data-words>Trivandrum Digital Marketing Guides</h2>
        <p class="svc-text">Go deeper on any topic before you decide.</p>
      </div>

      <div class="guide-grid-3">
        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>How to choose a digital marketing company in Trivandrum</h3>
          <p>Red flags, questions to ask and what good reporting looks like.</p>
          <a href="<?= url('blog.php') ?>" class="guide-card__link">Read the guide &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>Digital marketing cost in Trivandrum</h3>
          <p>Price ranges by channel and what each budget buys.</p>
          <a href="#free-audit-form" data-audit-modal="free-audit" data-audit-title="Request a Fixed Quote" class="guide-card__link">Request a fixed quote &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Local SEO for Trivandrum businesses</h3>
          <p>Google Business Profile, reviews and Malayalam content, step by step.</p>
          <a href="<?= url('seo.php') ?>" class="guide-card__link">Read the guide &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>Getting found in AI answers in Trivandrum</h3>
          <p>How local businesses get named by ChatGPT, Gemini and AI Overviews.</p>
          <a href="<?= url('ai-seo.php') ?>" class="guide-card__link">Read the guide &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>Digital marketing for clinics and hospitals</h3>
          <p>Appointments, reviews and local visibility for healthcare.</p>
          <a href="<?= url('lead-generation.php') ?>" class="guide-card__link">Read the guide &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Digital marketing glossary</h3>
          <p>SEO, AEO, GEO, CPL, ROAS and more in one line each.</p>
          <a href="<?= url('blog.php') ?>" class="guide-card__link">Read the guide &rarr;</a>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== WHO IS BEHIND YOUR WORK ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap guide-team__grid">
      <div class="guide-team__copy" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          About the Team
        </span>
        <h2 class="svc-title" data-words style="margin-bottom:20px;">Who is behind your AI SEO work</h2>
        <p>
          TechBound Innovations started in 2009 in Trivandrum with a simple belief: businesses deserve honest digital marketing that actually works. What began as a web development setup is now a full-service agency with specialists in SEO, social media, paid advertising, content and web development.
        </p>
        <p>
          We keep up with every change in how people search, including the AI tools your customers now use — from Google AI Overviews to ChatGPT and Perplexity.
        </p>
      </div>

      <div class="guide-team__cards" data-animate="up" style="--d:100ms">
        <div class="guide-card">
          <h3>Shabna Nazeer &mdash; CTO</h3>
          <p>Builds the technical foundation behind TechBound's search work across SEO, SMM and PPC, from site architecture and structured data to AI search visibility and ad performance measurement.</p>
        </div>

        <div class="guide-card">
          <h3>Our Head Office</h3>
          <p>6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, Kerala 695001</p>
          <ul class="guide-office-list">
            <li><a href="tel:+918606497677">+91 86064 97677</a> &middot; <a href="tel:+917736560333">+91 77365 60333</a></li>
            <li><a href="mailto:office@techbound.in">office@techbound.in</a></li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <?php
$faq_page  = 'trivandrum-guide';
$faq_title = 'Frequently Asked Questions';
require __DIR__ . '/includes/faq-section.php';
?>

  <!-- ===== LATEST FROM THE TECHBOUND BLOG ===== -->
  <?php if (!empty($guide_posts)): ?>
  <section class="services blog" data-nav="light">
    <div class="services__inner">
      <div class="services__head" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Latest Articles
        </span>
        <div class="services__row">
          <h2 class="services__title">Latest from the TechBound blog</h2>
          <p class="services__lead">Practical updates on SEO, AI search, advertising and digital marketing from our Trivandrum team.</p>
        </div>
      </div>

      <div class="blog__grid">
        <?php foreach ($guide_posts as $i => $gp):
          $postUrl   = url('blog-post.php?slug=' . rawurlencode($gp['slug'] ?? ''));
          $postImg   = blog_image_url($gp['image'] ?? '', $gp['category'] ?? null);
          $postTitle = htmlspecialchars($gp['title'] ?? '');
          $ts        = !empty($gp['published_at']) ? strtotime($gp['published_at']) : false;
          $dateAttr  = $ts ? date('Y-m-d', $ts) : '';
          $dateLabel = $ts ? date('F j, Y', $ts) : '';
        ?>
        <article class="blog-card" data-animate="up" style="--d:<?= $i * 100 ?>ms">
          <a href="<?= $postUrl ?>" class="blog-card__img">
            <img src="<?= htmlspecialchars($postImg) ?>" alt="<?= $postTitle ?>" loading="lazy">
          </a>
          <div class="blog-card__body">
            <?php if ($dateLabel): ?>
              <time class="blog-card__date" datetime="<?= $dateAttr ?>"><?= $dateLabel ?></time>
            <?php endif; ?>
            <h3 class="blog-card__title"><a href="<?= $postUrl ?>"><?= $postTitle ?></a></h3>
            <a href="<?= $postUrl ?>" class="blog-card__more">Read More <span>→</span></a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>

      <div class="blog__more">
        <a href="<?= url('blog.php') ?>" class="btn btn--primary btn--sm btn--arrow">Explore More</a>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- ===== FREE AUDIT & QUOTE FORM ===== -->
  <section class="svc-section guide-audit" id="free-audit-form" data-nav="light">
    <div class="svc-wrap guide-audit__grid">
      <div data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Free Audit &amp; Quote
        </span>
        <h2 class="svc-title" data-words>Get Your Free Audit &amp; Quote</h2>
        <p class="svc-text" style="margin-top:16px;">
          Tell us about your business. Within one working day a specialist will call you, and you'll receive a free audit of your Google, Maps and AI search visibility, the three fixes worth doing first and a fixed quote. No obligation.
        </p>

        <div class="guide-offices">
          <div class="guide-office-item">
            <strong>Head Office &mdash; Statue, Trivandrum</strong>
            <p>6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, Kerala 695001</p>
          </div>
          <div class="guide-office-item">
            <strong>Technical Wing &mdash; Technopark</strong>
            <p>SBC 7, Thejaswini Building, Technopark Campus, Trivandrum 695581</p>
          </div>
          <div class="guide-office-item">
            <strong>Kochi Office &mdash; Ernakulam</strong>
            <p>Suraj Buildings, Giri Nagar Club Rd, Kadavanthra, Ernakulam 682020</p>
          </div>
          <p class="svc-text" style="margin-top:4px; font-size:15px;">
            <a href="tel:+918606497677" style="color:var(--brand); font-weight:600; text-decoration:none;">+91 86064 97677</a> &middot; Mon to Fri, 9.00 am to 6.30 pm
          </p>
        </div>
      </div>

      <div class="guide-audit__form-card" data-animate="up" style="--d:100ms">
        <form id="guideAuditForm" class="guide-form" method="post" action="<?= url('send-contact.php') ?>">
          <input type="hidden" name="service" value="Free AI Visibility Audit">
          <input type="hidden" name="company" id="g-company-hidden" value="">
          <input type="hidden" name="message" id="g-message-hidden" value="">
          <input type="hidden" name="_form_ts" value="<?= time() ?>">
          <input type="hidden" name="recaptcha_token" id="g-recaptcha-token" value="">
          <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
            <input type="text" name="fax_number" tabindex="-1" autocomplete="off">
          </div>

          <div class="guide-field">
            <label for="g-name">Your Name *</label>
            <input type="text" id="g-name" name="name" required placeholder="Your full name">
          </div>

          <div class="guide-field">
            <label for="g-email">Work email *</label>
            <input type="email" id="g-email" name="email" required placeholder="you@company.com">
          </div>

          <div class="guide-field">
            <label for="g-phone">Phone or WhatsApp *</label>
            <input type="tel" id="g-phone" name="phone" required placeholder="+91 98765 43210">
          </div>

          <div class="guide-field">
            <label for="g-url">Website URL (optional)</label>
            <input type="url" id="g-url" name="site_url" placeholder="https://yourwebsite.com">
          </div>

          <div class="guide-field">
            <label for="g-competitors">Two competitor websites</label>
            <input type="text" id="g-competitors" name="competitors" placeholder="e.g. competitor1.com, competitor2.com">
          </div>

          <button type="submit" class="btn btn--primary btn--arrow" style="align-self:flex-start;">Request my free AI visibility audit</button>
          <p id="guideFormStatus" class="guide-form__status" aria-live="polite"></p>
        </form>
      </div>
    </div>
  </section>

</main>

<script>
(function () {
  var form = document.getElementById('guideAuditForm');
  var statusEl = document.getElementById('guideFormStatus');
  if (!form || !statusEl) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var siteUrl = (document.getElementById('g-url').value || '').trim();
    var competitors = (document.getElementById('g-competitors').value || '').trim();
    document.getElementById('g-company-hidden').value = siteUrl;
    document.getElementById('g-message-hidden').value =
      'Free AI Visibility Audit Request\n' +
      'Website URL: ' + (siteUrl || 'Not provided') + '\n' +
      'Two competitor websites: ' + (competitors || 'Not provided');

    var btn = form.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;
    statusEl.className = 'guide-form__status';
    statusEl.textContent = 'Sending your request...';

    var getToken = (typeof window.tbGetRecaptchaToken === 'function')
      ? window.tbGetRecaptchaToken('free_audit')
      : Promise.resolve('');

    getToken.then(function (token) {
      var tokenEl = document.getElementById('g-recaptcha-token');
      if (tokenEl) tokenEl.value = token || '';
      return fetch(form.getAttribute('action'), {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data && data.ok) {
          statusEl.className = 'guide-form__status is-ok';
          statusEl.textContent = data.message || 'Thank you! A specialist will call you within one working day.';
          form.reset();
        } else {
          statusEl.className = 'guide-form__status is-err';
          statusEl.textContent = (data && data.message) || 'Please check your details and try again.';
        }
      })
      .catch(function () {
        statusEl.className = 'guide-form__status is-err';
        statusEl.textContent = 'Could not send right now. Please call +91 86064 97677.';
      })
      .finally(function () {
        if (btn) btn.disabled = false;
      });
  });
})();
</script>

<?php require __DIR__ . '/includes/footer-guide.php'; ?>
