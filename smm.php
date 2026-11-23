<?php
$page_title = 'Social Media Management Agency in Trivandrum | TechBound';
$page_desc  = 'TechBound builds a social presence that reflects your brand, earns your audience\'s trust, and turns followers into real business. Expert SMM from Trivandrum.';
$page_styles = ['css/seo.css', 'css/smm.css'];


// Fetch FAQs safely (graceful fallback if DB not configured on remote host)
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
<section class="hero hero--inner" style="background-image: url('<?= asset('assets/services/smm-hero-1.jpg') ?>');">
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <div class="hero__tagline-wrap">
      <nav class="hero__crumbs" aria-label="Breadcrumb">
        <a href="<?= url('index.php') ?>">Home</a><span>/</span>
        <a href="<?= url('services.php') ?>">Services</a><span>/</span>
        <span class="is-current">Social Media Marketing</span>
      </nav>
      <div class="hero__line"></div>
    </div>

    <div class="hero__body">
      <div class="hero__text">
        <h1 class="hero__title">Social Media Marketing Agency in Kerala</h1>
        <p class="hero__desc">
          Being on social media and actually growing on it are two very different things. TechBound builds a social presence that reflects your brand, earns audience trust, and turns followers into real business.
        </p>
      </div>

      <div class="hero__buttons">
        <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow">Get a Free Audit</a>
        <a href="#process" class="btn btn--outline btn--arrow">See How We Work</a>
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
          <div class="ai-stat__num display-5 fw-bold mb-1"><span data-count="15">15</span><sup>+</sup></div>
          <div class="ai-stat__label text-muted fs-6 fw-medium">Years in Digital Marketing</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="ai-stat">
          <div class="ai-stat__num display-5 fw-bold mb-1"><span data-count="200">200</span><sup>+</sup></div>
          <div class="ai-stat__label text-muted fs-6 fw-medium">Businesses Grown</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="ai-stat">
          <div class="ai-stat__num display-5 fw-bold mb-1"><span data-count="2.9">2.9</span> L<sup>+</sup></div>
          <div class="ai-stat__label text-muted fs-6 fw-medium">Leads Generated</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHO THIS IS FOR ===== -->
<section class="svc-section svc-section--tint">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 50px; max-width: 800px; margin-left: auto; margin-right: auto;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Who This Is For
      </span>
      <h2 class="svc-title">Your Business Is Active on Social.<br>But Is It Actually Working?</h2>
      <p class="svc-text" style="margin: 18px auto 0; font-size: 18px;">Posting regularly and seeing real results are two completely different things. If any of these feel familiar, you’re in the right place.</p>
    </div>
    
    <div class="smm-split-list">
      <!-- Negative Column -->
      <div class="smm-list-col is-negative">
        <div class="smm-list-header">
          <h3>What businesses come to us with:</h3>
        </div>
        <ul>
          <li>Posting regularly but getting little to no engagement or reach.</li>
          <li>Social pages that look inconsistent (different fonts, tones, visuals).</li>
          <li>A brand that isn't visible online even though the business is well established offline.</li>
          <li>Negative reviews or comments hurting the brand's reputation with no strategy to address them.</li>
          <li>No clear brand voice — every post feels like it was made by a different person.</li>
          <li>Followers that don't convert into inquiries, leads, or sales.</li>
        </ul>
      </div>
      
      <!-- Positive Column -->
      <div class="smm-list-col is-positive">
        <div class="smm-list-header">
          <h3>What it looks like with the right strategy:</h3>
        </div>
        <ul>
          <li>A consistent, recognisable brand presence across every platform you're on.</li>
          <li>Content that your audience actually stops to read, watch, and share.</li>
          <li>A brand reputation that builds trust before a customer even contacts you.</li>
          <li>Real inquiries and conversations coming in through social channels.</li>
          <li>A social presence that reflects the actual quality and credibility of your business.</li>
          <li>One team handling everything: strategy, content, posting, and reporting.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ===== BRAND CHALLENGES ===== -->
<section class="svc-section">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 40px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Brand Challenges We Fix
      </span>
      <h2 class="svc-title">Three Brand Problems That Quietly Cost You Business</h2>
      <p class="svc-text" style="margin: 18px auto 0;">These aren’t just social media problems. They’re business problems that show up on social media.</p>
    </div>
    
    <div class="ai-features ai-features--3">
      <div class="ai-feature">
        <h3>Your Brand Is Invisible Online</h3>
        <p>You've built a solid business but your social presence doesn't reflect it. When people search for you, they find thin content or inactive pages and move on. Visibility isn't optional anymore; it's where trust begins.</p>
      </div>
      <div class="ai-feature">
        <h3>Brand Inconsistency Is Eroding Trust</h3>
        <p>Your Instagram looks different from your Facebook. Your captions don't match your website tone. Inconsistency signals unprofessionalism, even when your product is excellent. A unified brand voice is what separates forgettable brands from trusted ones.</p>
      </div>
      <div class="ai-feature">
        <h3>Your Online Reputation Needs Attention</h3>
        <p>Negative reviews, unanswered comments, or a lack of social proof silently push potential customers away. Reputation management isn't just PR; it's sales. We help you build and protect the kind of online reputation that makes people choose you.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHY TECHBOUND ===== -->
<section class="svc-section svc-section--tint">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 40px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Why TechBound
      </span>
      <h2 class="svc-title">Built Around Your Business, Not a Template</h2>
    </div>
    
    <div class="ai-features">
      <div class="ai-feature">
        <h3>We Start by Listening, Not Pitching</h3>
        <p>Before we create a single post, we take the time to understand your business, your audience, your competitors, and what your brand genuinely stands for.</p>
      </div>
      <div class="ai-feature">
        <h3>One Brand Voice. Every Platform.</h3>
        <p>Whether it's LinkedIn, Instagram, Facebook, or YouTube—your brand looks, sounds, and feels the same everywhere. That consistency is what makes audiences trust you.</p>
      </div>
      <div class="ai-feature">
        <h3>Engagement That Leads to Real Business</h3>
        <p>Likes and follows are nice. Inquiries and conversions are better. Every content strategy we build has an end goal tied to your business, not just vanity metrics.</p>
      </div>
      <div class="ai-feature">
        <h3>You're Never Left in the Dark</h3>
        <p>Regular updates, clear monthly reports, and open communication at every stage. You'll always know what's going out, how it's performing, and what's being adjusted.</p>
      </div>
      <div class="ai-feature">
        <h3>15+ Years Across Industries</h3>
        <p>We've worked with businesses across India, the Middle East, Europe, and beyond in healthcare, retail, hospitality, education, and more. Your strategy benefits from insights most agencies haven't seen.</p>
      </div>
      <div class="ai-feature">
        <h3>Brand Safety Built In</h3>
        <p>Every content piece goes through a quality lens. Comments, reviews, and community interactions are managed with care so your brand is never left exposed.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== PROCESS ===== -->
<section class="svc-section" id="process">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 50px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Process
      </span>
      <h2 class="svc-title">How We Turn Your Social Presence into a Business Asset</h2>
      <p class="svc-text" style="margin: 18px auto 0;">Every step is deliberate—designed not just to make your pages look good, but to make them work for your business.</p>
    </div>
    
    <div class="ai-v-timeline">
      <div class="ai-v-step">
        <div class="ai-v-dot"></div>
        <div class="ai-v-content">
          <span class="ai-v-num">01</span>
          <h3>Brand & Audience Discovery</h3>
          <p>Deep dive into your brand identity, target audience, competitors, and current social performance. We don't assume—we research. This shapes everything that follows.</p>
        </div>
      </div>
      <div class="ai-v-step">
        <div class="ai-v-dot"></div>
        <div class="ai-v-content">
          <span class="ai-v-num">02</span>
          <h3>Platform Strategy & Content Planning</h3>
          <p>We identify which platforms your audience actually uses, set the right tone for each, and build a content calendar that balances awareness and conversion goals.</p>
        </div>
      </div>
      <div class="ai-v-step">
        <div class="ai-v-dot"></div>
        <div class="ai-v-content">
          <span class="ai-v-num">03</span>
          <h3>Brand Identity Alignment</h3>
          <p>We standardise your visual identity, brand voice, and content style across all platforms so every post reinforces who you are, not confuses your audience.</p>
        </div>
      </div>
      <div class="ai-v-step">
        <div class="ai-v-dot"></div>
        <div class="ai-v-content">
          <span class="ai-v-num">04</span>
          <h3>Content Creation & Scheduling</h3>
          <p>Creatives, captions, reels, carousels, stories—designed for your brand and scheduled at optimal times. Every piece is reviewed for quality before it goes live.</p>
        </div>
      </div>
      <div class="ai-v-step">
        <div class="ai-v-dot"></div>
        <div class="ai-v-content">
          <span class="ai-v-num">05</span>
          <h3>Community Management</h3>
          <p>We manage comments, respond to messages, and monitor your brand mentions so your audience feels heard and your reputation is actively maintained.</p>
        </div>
      </div>
      <div class="ai-v-step">
        <div class="ai-v-dot"></div>
        <div class="ai-v-content">
          <span class="ai-v-num">06</span>
          <h3>Performance Reporting</h3>
          <p>Monthly reports with clear metrics—reach, engagement, follower growth, and lead activity. We explain what the numbers mean and how we're adjusting the plan.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== PLATFORMS ===== -->
<section class="svc-section svc-section--tint">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 40px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Platforms We Manage
      </span>
      <h2 class="svc-title">Where Your Audience Is, We're There</h2>
      <p class="svc-text" style="margin: 18px auto 0;">We don’t push you to be on every platform. We identify where your customers actually are and build your presence there deliberately.</p>
    </div>
    
        <div class="platforms-grid">
      <!-- Facebook -->
      <div class="platform-card">
        <div class="platform-card__icon" style="color: #1877F2;">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </div>
        <h3>Facebook</h3>
        <p>Community-focused content and audience optimisation that improves visibility, engagement, and lead generation.</p>
      </div>

      <!-- Instagram -->
      <div class="platform-card">
        <div class="platform-card__icon" style="color: #E1306C;">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
        </div>
        <h3>Instagram</h3>
        <p>Optimised visual content, Reels, and Stories that increase reach, brand recognition, and audience engagement.</p>
      </div>

      <!-- LinkedIn -->
      <div class="platform-card">
        <div class="platform-card__icon" style="color: #0A66C2;">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </div>
        <h3>LinkedIn</h3>
        <p>Authority building content optimised for professional credibility, B2B visibility, and high-value connections.</p>
      </div>

      <!-- YouTube -->
      <div class="platform-card">
        <div class="platform-card__icon" style="color: #FF0000;">
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
        </div>
        <h3>YouTube</h3>
        <p>Search-optimised video content that builds trust, improves discoverability, and drives long-term brand awareness.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHAT'S INCLUDED ===== -->
<section class="svc-section">
  <div class="svc-wrap">
    <div style="text-align: center; margin-bottom: 40px;">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        What's Included
      </span>
      <h2 class="svc-title">Everything You Need. Nothing You Don't.</h2>
      <p class="svc-text" style="margin: 18px auto 0;">Here’s exactly what working with TechBound on social media looks like—no hidden extras, no vague deliverables.</p>
    </div>
    
    <div class="ai-features">
      <div class="ai-feature"><h3>Brand & Competitor Audit</h3><p>Deep analysis of where you stand today versus your closest competitors.</p></div>
      <div class="ai-feature"><h3>Platform Strategy</h3><p>Specific plans for the platforms that actually matter to your target audience.</p></div>
      <div class="ai-feature"><h3>Brand Identity Alignment</h3><p>Standardising your voice and visuals so everything looks cohesive.</p></div>
      <div class="ai-feature"><h3>Custom Content Creation</h3><p>Creatives, captions, reels, and carousels designed specifically for your brand.</p></div>
      <div class="ai-feature"><h3>Community Management</h3><p>Handling comments, messages, and brand mentions so no lead is left waiting.</p></div>
      <div class="ai-feature"><h3>Monthly Reporting</h3><p>Clear ROI tracking and plain-language insights on exactly what worked.</p></div>
    </div>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="faq" id="faq" data-nav="light">
  <div class="faq__inner">
    <h2 class="faq__title">Frequently Asked Questions</h2>

    <div class="faq__list">
      <?php if (!empty($faqs)): ?>
        <?php foreach ($faqs as $index => $faq):
          $q = trim($faq['question']);
          if (!preg_match('/^\d+\.\s/', $q)) { $q = ($index + 1) . '. ' . $q; }
          $is_open = ($index === 0);
        ?>
          <div class="faq__item<?= $is_open ? ' is-open' : '' ?>">
            <h3>
              <button class="faq__question" type="button" aria-expanded="<?= $is_open ? 'true' : 'false' ?>" aria-controls="faq-<?= $index + 1 ?>">
                <?= htmlspecialchars($q) ?>
              </button>
            </h3>
            <div class="faq__answer" id="faq-<?= $index + 1 ?>">
              <div class="faq__answer-inner">
                <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="faq__item is-open">
          <h3>
            <button class="faq__question" type="button" aria-expanded="true" aria-controls="faq-1">
              1. What is the difference between having a social media account and social media marketing?
            </button>
          </h3>
          <div class="faq__answer" id="faq-1">
            <div class="faq__answer-inner">
              <p>A social media account is passive—you post and hope someone sees it. Strategic marketing is active and purposeful, designed with specific business outcomes like lead generation or brand awareness in mind.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-2">
              2. Do you handle both organic content and paid ads?
            </button>
          </h3>
          <div class="faq__answer" id="faq-2">
            <div class="faq__answer-inner">
              <p>Yes. Organic reach has declined significantly across most platforms. We combine organic content strategy with targeted paid campaigns to ensure your message reaches the right people.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-3">
              3. Which platforms should my business be on?
            </button>
          </h3>
          <div class="faq__answer" id="faq-3">
            <div class="faq__answer-inner">
              <p>It depends on your customers. B2B clients usually benefit most from LinkedIn, while B2C brands thrive on Instagram and Facebook. We don't push you to be everywhere; we build where it matters.</p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ===== CTA ===== -->
<section class="svc-cta">
  <h2>Ready to Build a Social Presence Your Business Deserves?</h2>
  <p>Your audience is on social media right now discovering brands. If you're looking for a reliable partner that delivers results you can see, let's have an honest conversation.</p>
  <a class="btn-outline" href="<?= url('contact.php') ?>">Let's Talk
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
  </a>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>