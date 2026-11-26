<?php
$page_title  = 'Digital Marketing Agency in Kochi | TechBound';
$page_desc   = 'SEO, AI search, social media, ads and websites for Kochi businesses. Kadavanthra office, 15+ years since 2009. Get a free visibility audit.';
$page_styles  = ['css/seo.css', 'css/guide.css'];
$page_scripts = ['js/pages/home/testimonials.js'];
$page_slug    = 'digital-marketing-agency-in-kochi';

$schema_data = json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'        => 'ProfessionalService',
            'name'         => 'TechBound Innovations - Kochi',
            'url'          => 'https://techbound.in/digital-marketing-agency-in-kochi/',
            'telephone'    => '+91-7736560333',
            'address'      => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Suraj Buildings, Giri Nagar Club Rd, Giri Nagar, Kadavanthra',
                'addressLocality' => 'Kochi',
                'addressRegion'   => 'Kerala',
                'postalCode'      => '682020',
                'addressCountry'  => 'IN',
            ],
            'openingHours' => 'Mo-Fr 09:30-18:30',
            'parentOrganization' => [
                '@type'        => 'Organization',
                'name'         => 'TechBound Innovations',
                'url'          => 'https://techbound.in/',
                'foundingDate' => '2009',
                'sameAs'       => [
                    'https://www.facebook.com/techboundDigitalAgency',
                    'https://www.instagram.com/techboundinnovations/',
                    'https://www.linkedin.com/company/techboundinnovations',
                    'https://www.youtube.com/@techboundinnovations1257',
                    'https://x.com/techbounddgtl',
                ],
            ],
        ],
        [
            '@type'      => 'FAQPage',
            'mainEntity' => [
                [
                    '@type'          => 'Question',
                    'name'           => 'Do you have an office in Kochi?',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes. Our Kochi office is at Suraj Buildings, Giri Nagar Club Road, Kadavanthra, Ernakulam 682020. Our head office is opposite the Secretariat in Thiruvananthapuram.'],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'How long before we see results?',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Discovery takes 2 to 3 weeks and setup 4 to 6 weeks. Early signals usually show in weeks 8 to 12; steady results build over 4 to 6 months.'],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Can you guarantee first-page rankings or ChatGPT mentions?',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'No, and be careful with anyone who does. We improve what we control and report honestly every month.'],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Do we need every service?',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'No. We recommend the channel most likely to pay back first, then add others once results are proven.'],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Will we have a dedicated team?',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes. You get named people who know your business, with regular updates and plain-language reports.'],
                ],
                [
                    '@type'          => 'Question',
                    'name'           => 'Do you work with businesses outside Kochi?',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes, across Kerala, India and 6+ countries, including clients in the Middle East, Europe and North America.'],
                ],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

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
          <span class="is-current">TechBound Kochi &middot; Kadavanthra, Ernakulam</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Digital Marketing Agency in Kochi</h1>
          <p class="hero__desc">
            SEO, AI search visibility, social media, Google and Meta ads, and websites that turn visits into enquiries, run by one team that has been doing this since 2009, now with an office in Kadavanthra.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="#audit" data-audit-modal="free-audit" data-audit-title="Get Your Free Kochi Visibility Audit" class="btn btn--primary btn--arrow">Get my free visibility audit</a>
          <a href="tel:+917736560333" class="btn btn--outline btn--arrow">Call Us</a>
        </div>

        <p style="margin-top:16px;font-size:14.5px;color:rgba(255,255,255,.78);">
          15+ years in digital marketing &middot; Clients in 6+ countries &middot; 250+ businesses served
        </p>
      </div>
    </div>
  </section>

  <!-- ===== PROOF STRIP ===== -->
  <section class="svc-section" style="padding-top:56px;padding-bottom:56px;" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-stats" style="margin-top:0;" data-animate="up">
        <div class="guide-stat">
          <div class="guide-stat__num">15+</div>
          <div class="guide-stat__label">Years in digital marketing (since 2009)</div>
        </div>
        <div class="guide-stat">
          <div class="guide-stat__num">6+</div>
          <div class="guide-stat__label">Countries served</div>
        </div>
        <div class="guide-stat">
          <div class="guide-stat__num">250+</div>
          <div class="guide-stat__label">Clients delivered</div>
        </div>
        <div class="guide-stat">
          <div class="guide-stat__num">2.9 L+</div>
          <div class="guide-stat__label">Leads generated</div>
        </div>
      </div>
      <p class="svc-text" style="margin-top:24px;max-width:100%;">
        We work in Google Search Console, Google Analytics 4 and Schema.org structured data, and report in plain language.
      </p>
    </div>
  </section>

  <!-- ===== PROBLEM & SOLUTION ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <h2 class="svc-title" data-words>Kochi customers compare you before they call you</h2>
        <p class="svc-text">
          A buyer in Kakkanad, Edappally or Vyttila checks Google, reads reviews, scrolls Instagram and now asks ChatGPT or Google's AI answers for a shortlist. If your business is missing at any of those points, the enquiry goes to whoever shows up.
        </p>
      </div>

      <div class="seo-compare__grid" style="margin-top:44px;">
        <div class="seo-compare__left" data-animate="up">
          <h3 class="seo-compare__heading">What we hear from Kochi businesses</h3>
          <ul class="seo-compare__list seo-compare__list--neg">
            <li>"We're on page 3 and nobody scrolls that far."</li>
            <li>"We get traffic but no enquiries."</li>
            <li>"We only stay visible while we pay for ads."</li>
            <li>"ChatGPT names our competitor, not us."</li>
          </ul>
        </div>

        <div class="seo-compare__card" data-animate="up" style="--d:120ms">
          <h3 class="seo-compare__card-title">What changes when it is done right</h3>
          <ul class="seo-compare__list seo-compare__list--pos">
            <li>You appear when customers search for what you sell.</li>
            <li>Your site is built to turn visits into calls and forms.</li>
            <li>Organic leads keep coming without raising ad spend every month.</li>
            <li>Your business is easier for AI tools to find, understand and cite.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== SERVICES ===== -->
  <section class="svc-section" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <h2 class="svc-title" data-words>Everything your Kochi business needs online, under one plan</h2>
      </div>

      <div class="guide-grid-3">
        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>Search Engine Optimization</h3>
          <p>Technical fixes, local SEO and content that move you up for the searches Kochi buyers make.</p>
          <a href="<?= url('seo.php') ?>" class="guide-card__link">See our SEO services &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>AI SEO, AEO and GEO</h3>
          <p>Get named in Google AI Overviews, ChatGPT, Gemini and Perplexity answers, tracked against a fixed set of buyer questions.</p>
          <a href="<?= url('ai-seo.php') ?>" class="guide-card__link">How AI search optimisation works &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Social Media Management</h3>
          <p>Instagram, Facebook and LinkedIn content planned around enquiries, with English and Malayalam captions where they land better.</p>
          <a href="<?= url('smm.php') ?>" class="guide-card__link">Social media management plans &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>Online Advertising</h3>
          <p>Google and Meta campaigns that bring leads now while organic visibility builds.</p>
          <a href="<?= url('online-advertising.php') ?>" class="guide-card__link">Paid advertising for faster leads &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>Website Development</h3>
          <p>Fast, mobile-first websites that search engines and AI crawlers can read.</p>
          <a href="<?= url('website-development.php') ?>" class="guide-card__link">Website development in Kerala &rarr;</a>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Lead Generation</h3>
          <p>Campaigns and landing pages measured on cost per lead and lead quality, not clicks.</p>
          <a href="<?= url('lead-generation.php') ?>" class="guide-card__link">Lead generation services &rarr;</a>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== AI SEARCH VISIBILITY BAND ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap guide-team__grid" style="align-items:center;">
      <div class="guide-team__copy" data-animate="up">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          AI search visibility
        </span>
        <h2 class="svc-title" data-words style="margin-bottom:18px;">Is your business named when Kochi customers ask AI?</h2>
        <p>
          We take 20 to 30 real questions your buyers ask, run them through ChatGPT, Gemini, Perplexity and Google, and show you who gets named today. Then we fix what we control: crawler access, page structure, consistent business details and proof. We re-run the same questions every month so changes mean something.
        </p>
        <p style="font-size:15px;color:#55635d;border-top:1px solid #cdd7d1;padding-top:16px;">
          No agency can guarantee an AI tool will cite you. We show the work and report what moves.
        </p>
        <div style="margin-top:24px;">
          <a href="#audit" data-audit-modal="ai-audit" data-audit-title="Run Your Free AI Visibility Check" class="btn btn--primary btn--arrow">Run my free AI visibility check</a>
        </div>
      </div>

      <div data-animate="up" style="--d:100ms">
        <img src="<?= asset('assets/services/ai-seo-hero-2.jpg') ?>" alt="TechBound AI visibility analysis across ChatGPT, Gemini, Perplexity and Google AI Overviews" style="width:100%;height:auto;border-radius:16px;display:block;box-shadow:0 16px 40px rgba(10,18,32,.12);" loading="lazy">
      </div>
    </div>
  </section>

  <!-- ===== WHY KOCHI BUSINESSES WORK WITH TECHBOUND ===== -->
  <section class="svc-section" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <h2 class="svc-title" data-words>Why Kochi businesses work with TechBound</h2>
      </div>

      <div class="guide-grid-3">
        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>15+ years through every search shift</h3>
          <p>We started in 2009 and have adapted from classic search to AI answers without changing the basics: listen first, then build.</p>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>One plan across every channel</h3>
          <p>SEO, social, ads and your website share one message and one monthly report instead of four vendors.</p>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>A team you can meet</h3>
          <p>Kadavanthra for Kochi clients, with our Trivandrum head office and Technopark technical wing behind it.</p>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up">
          <h3>Reporting tied to enquiries</h3>
          <p>Leads, cost per lead and AI-referred visits, not follower counts.</p>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:80ms">
          <h3>No guaranteed-ranking promises</h3>
          <p>If a channel is not working in 60 to 90 days, we change the approach and tell you why.</p>
        </article>

        <article class="guide-card guide-card--soft" data-animate="up" style="--d:160ms">
          <h3>Local language, local search habits</h3>
          <p>English and Malayalam content where it performs, built around how Kochi actually searches.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== PROCESS ===== -->
  <section class="svc-section svc-section--tint" id="process" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <h2 class="svc-title" data-words>From first call to first leads</h2>
      </div>

      <div class="guide-grid-4">
        <article class="guide-card" data-animate="up">
          <span class="guide-num">01</span>
          <span class="guide-step-time">Week 0</span>
          <h3>Free audit</h3>
          <p>We review your site, Google Business Profile and AI visibility, and show you where enquiries leak.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:80ms">
          <span class="guide-num">02</span>
          <span class="guide-step-time">Weeks 1 to 3</span>
          <h3>Strategy</h3>
          <p>Discovery of your market, competitors and buyers; a 90-day plan with clear targets.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:160ms">
          <span class="guide-num">03</span>
          <span class="guide-step-time">Weeks 4 to 9</span>
          <h3>Build and launch</h3>
          <p>Fixes, content, campaigns and tracking go live.</p>
        </article>

        <article class="guide-card" data-animate="up" style="--d:240ms">
          <span class="guide-num">04</span>
          <span class="guide-step-time">From weeks 8 to 12</span>
          <h3>Results and refinement</h3>
          <p>Early signals show; mature results typically land in 4 to 6 months. Monthly report and review call throughout.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== WHAT CLIENTS SAY (Sliding Testimonials Marquee) ===== -->
  <section class="testimonials" id="testimonials" data-nav="dark">
    <div class="testimonials__inner">
      <div class="testimonials__heading">
        <span class="testimonials__eyebrow">Client Testimonials</span>
        <h2>What Clients Say</h2>
        <p>Real experiences. Meaningful results. Lasting partnerships.</p>
      </div>

      <?php
        $kochi_testimonials = [];
        try {
          require_once __DIR__ . '/includes/db.php';
          $tStmt = db()->query("SELECT quote, client, role FROM testimonials WHERE active = 1 ORDER BY sort_order ASC, id ASC");
          if ($tStmt) {
            $kochi_testimonials = $tStmt->fetchAll();
          }
        } catch (Throwable $e) {
          $kochi_testimonials = [];
        }
        if (empty($kochi_testimonials)) {
          $kochi_testimonials = [
            ['quote' => 'TechBound has been a great Digital Marketing partner over the last 5 years. We highly recommend them if you are in need of their Digital Marketing Services. The team is very responsive, professional and full of knowledge.', 'client' => 'Abhai Sasidharan', 'role' => 'Digital Marketing Partner'],
            ['quote' => 'We have used TechBound Digital Marketing Agency since Feb 2022 and I have been extremely impressed by the work and results they have brought our company.', 'client' => 'Princy Antony', 'role' => 'Digital Marketing Client'],
            ['quote' => 'Regardless of how urgent our needs were, the TechBound team responded quickly and professionally. They have long served as our marketing consultants and our website ranks have significantly improved.', 'client' => 'Mihila L', 'role' => 'Marketing Consulting'],
            ['quote' => 'I approached TechBound Innovations for our website to increase our website calls and maintain the top position. As they promised us, their strategies increased our website calls and maintain our websites in top position.', 'client' => 'Biju Kesavan', 'role' => 'SEO & Website Growth'],
            ['quote' => 'Working with TechBound Digital Marketing Company has been a wonderful experience. The team is very experienced, insightful, and extremely skilled. Their custom strategies generate excellent results.', 'client' => 'Firos Hussain', 'role' => 'Digital Marketing Strategy'],
            ['quote' => 'TechBound understood our goals and helped us strengthen our online presence.', 'client' => 'Client', 'role' => 'Digital Growth'],
            ['quote' => 'The website looks modern, works smoothly and represents our business well.', 'client' => 'Client', 'role' => 'Website Design'],
            ['quote' => 'We appreciated the clear communication and attention to detail throughout the project.', 'client' => 'Client', 'role' => 'Digital Services'],
          ];
        }
        $k_half   = (int)ceil(count($kochi_testimonials) / 2);
        $k_top    = array_slice($kochi_testimonials, 0, $k_half);
        $k_bottom = array_slice($kochi_testimonials, $k_half);
        if (empty($k_bottom)) $k_bottom = $k_top;
      ?>

      <div class="testimonials__stage">
        <div class="testimonial-row testimonial-row--top">
          <?php foreach ($k_top as $tr): ?>
          <article class="testimonial-card">
            <span class="testimonial-card__quote">&ldquo;</span>
            <p><?= htmlspecialchars($tr['quote']) ?></p>
            <div class="testimonial-card__footer">
              <span><?= htmlspecialchars($tr['client'] ?: 'Client') ?></span>
              <strong><?= htmlspecialchars($tr['role'] ?: 'Client Review') ?></strong>
            </div>
          </article>
          <?php endforeach; ?>
        </div>

        <div class="testimonial-row testimonial-row--bottom">
          <?php foreach ($k_bottom as $br): ?>
          <article class="testimonial-card">
            <span class="testimonial-card__quote">&ldquo;</span>
            <p><?= htmlspecialchars($br['quote']) ?></p>
            <div class="testimonial-card__footer">
              <span><?= htmlspecialchars($br['client'] ?: 'Client') ?></span>
              <strong><?= htmlspecialchars($br['role'] ?: 'Client Review') ?></strong>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== INDUSTRIES & INVESTMENT ===== -->
  <section class="svc-section svc-section--tint" data-nav="light">
    <div class="svc-wrap">
      <div class="guide-head" data-animate="up">
        <h2 class="svc-title" data-words>Built for businesses whose customers research before they buy</h2>
      </div>

      <div class="guide-chips" style="margin-top:28px;" data-animate="up">
        <span>Real estate</span>
        <span>Healthcare and clinics</span>
        <span>Education and training</span>
        <span>Professional services</span>
        <span>B2B and IT services</span>
        <span>Ecommerce and D2C</span>
        <span>Interiors and home services</span>
      </div>

      <p class="svc-text" style="margin-top:20px;max-width:760px;">
        If your buyers compare options or ask "who is best for…", search and AI answers already shape their shortlist.
      </p>

      <div class="guide-callout" style="margin-top:48px;" data-animate="up">
        <div>
          <h3>Plans scoped to your budget, fixed before work starts</h3>
          <p class="svc-text" style="margin-top:10px;max-width:640px;">
            Most clients start with one strong channel, prove the return, then expand. We quote a fixed monthly scope after the audit call.
          </p>
        </div>
        <div class="guide-callout__actions">
          <a href="#audit" data-audit-modal="free-audit" data-audit-title="Get Your Free Kochi Audit & Quote" class="btn btn--primary btn--arrow">Get my free audit and quote</a>
        </div>
      </div>
    </div>
  </section>

  <?php
$faq_page  = 'kochi';
$faq_title = 'Questions Kochi businesses ask us';
require __DIR__ . '/includes/faq-section.php';
?>

  <!-- ===== FORM + KOCHI LOCATION ===== -->
  <section class="svc-section svc-section--tint" id="audit" data-nav="light">
    <div class="svc-wrap guide-audit__grid">
      <div class="guide-audit__form-card" style="background:#ffffff;" data-animate="up">
        <h2 class="svc-title" style="margin-top:0;font-size:clamp(26px,2.6vw,34px);">Get your free Kochi visibility audit</h2>
        <p class="svc-text" style="margin:12px 0 24px;">
          Share your website and two competitors. Within 3 working days you get a written summary of where you rank on Google, who AI tools recommend in your category, and the three fixes worth doing first. Free, no obligation.
        </p>

        <form id="kochiAuditForm" class="guide-form" method="post" action="<?= url('send-contact.php') ?>">
          <input type="hidden" name="service" value="Kochi Visibility Audit">
          <input type="hidden" name="company" id="k-company-hidden" value="">
          <input type="hidden" name="message" id="k-message-hidden" value="">
          <input type="hidden" name="_form_ts" value="<?= time() ?>">
          <input type="hidden" name="recaptcha_token" id="k-recaptcha-token" value="">
          <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
            <input type="text" name="fax_number" tabindex="-1" autocomplete="off">
          </div>

          <div class="guide-field">
            <label for="k-name">Full name *</label>
            <input id="k-name" name="name" type="text" required placeholder="e.g. Anjali Menon">
          </div>
          <div class="guide-field">
            <label for="k-phone">Phone or WhatsApp *</label>
            <input id="k-phone" name="phone" type="tel" required placeholder="+91">
          </div>
          <div class="guide-field">
            <label for="k-email">Work email *</label>
            <input id="k-email" name="email" type="email" required placeholder="you@company.com">
          </div>
          <div class="guide-field">
            <label for="k-site">Website URL (optional)</label>
            <input id="k-site" name="site_url" type="url" placeholder="https://">
          </div>
          <div class="guide-field">
            <label for="k-comp">Two competitor websites (optional)</label>
            <input id="k-comp" name="competitors" type="text" placeholder="competitor1.com, competitor2.com">
          </div>

          <button class="btn btn--primary btn--arrow" type="submit" style="align-self:flex-start;">Send me my free audit</button>
          <p id="kochiFormStatus" class="guide-form__status" role="status" aria-live="polite"></p>
          <p class="svc-text" style="font-size:14px;margin-top:4px;">
            We reply Monday to Friday, 9.30 am to 6.30 pm. Prefer to talk? Call <a href="tel:+917736560333" style="color:var(--brand);font-weight:600;text-decoration:none;">+91 77365 60333</a>.
          </p>
        </form>
      </div>

      <div data-animate="up" style="--d:100ms">
        <div style="border-radius:16px;overflow:hidden;border:1px solid #d5ddd8;background:#fff;">
          <iframe
            src="https://www.google.com/maps?q=Suraj+Buildings,+Giri+Nagar+Club+Rd,+Giri+Nagar,+Kadavanthra,+Ernakulam,+Kerala+682020&output=embed"
            width="100%"
            height="320"
            style="border:0;display:block;"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="TechBound Kochi, Kadavanthra location"></iframe>
        </div>

        <div class="guide-offices" style="margin-top:24px;">
          <div class="guide-office-item" style="background:#ffffff;">
            <strong>TechBound Kochi</strong>
            <p>Suraj Buildings, Giri Nagar Club Rd, Giri Nagar, Kadavanthra, Ernakulam, Kerala 682020</p>
            <p style="margin-top:8px;">Mon to Fri, 9.30 am to 6.30 pm<br><a href="tel:+917736560333" style="color:var(--brand);font-weight:600;text-decoration:none;">+91 77365 60333</a></p>
          </div>
          <div class="guide-office-item" style="background:#ffffff;">
            <strong>Head Office &mdash; Trivandrum</strong>
            <p>6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram 695001</p>
            <p style="margin-top:8px;"><a href="<?= url('digital-marketing-trivandrum-guide.php') ?>" style="color:var(--brand);font-weight:600;text-decoration:none;">Read about our Trivandrum head office and full services &rarr;</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<script>
(function () {
  var form = document.getElementById('kochiAuditForm');
  var statusEl = document.getElementById('kochiFormStatus');
  if (!form || !statusEl) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var siteUrl = (document.getElementById('k-site').value || '').trim();
    var competitors = (document.getElementById('k-comp').value || '').trim();
    document.getElementById('k-company-hidden').value = siteUrl;
    document.getElementById('k-message-hidden').value =
      'Kochi Visibility Audit Request\n' +
      'Website URL: ' + (siteUrl || 'Not provided') + '\n' +
      'Two competitor websites: ' + (competitors || 'Not provided');

    var btn = form.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;
    statusEl.className = 'guide-form__status';
    statusEl.textContent = 'Sending your request...';

    var getToken = (typeof window.tbGetRecaptchaToken === 'function')
      ? window.tbGetRecaptchaToken('kochi_audit')
      : Promise.resolve('');

    getToken.then(function (token) {
      var tokenEl = document.getElementById('k-recaptcha-token');
      if (tokenEl) tokenEl.value = token || '';
      return fetch(form.getAttribute('action'), {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
    })
      .then(function (r) {
        return r.json().catch(function () { return { ok: false, message: 'Unexpected server response.' }; });
      })
      .then(function (data) {
        if (data && data.ok) {
          statusEl.className = 'guide-form__status is-ok';
          statusEl.textContent = data.message || 'Thank you! We will send your Kochi visibility audit within 3 working days.';
          form.reset();
        } else {
          statusEl.className = 'guide-form__status is-err';
          statusEl.textContent = (data && data.message) || 'Please check your details and try again.';
        }
      })
      .catch(function () {
        statusEl.className = 'guide-form__status is-err';
        statusEl.textContent = 'Could not send right now. Please call +91 77365 60333.';
      })
      .finally(function () {
        if (btn) btn.disabled = false;
      });
  });
})();
</script>

<?php require __DIR__ . '/includes/footer-kochi.php'; ?>
