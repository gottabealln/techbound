<?php
$page_title   = 'TechBound | Digital Marketing Agency in Trivandrum, Kerala';
$page_desc    = 'TechBound is a premier digital marketing agency in Trivandrum, Kerala. We scale businesses with data-driven SEO, PPC campaigns, social media marketing, and web development.';
$header_light = false;
$page_scripts = ['js/pages/home/process.js', 'js/pages/home/counter.js', 'js/pages/home/testimonials.js', 'js/pages/home/words.js'];

$faqs = [];
try {
  require_once __DIR__ . '/includes/db.php';
  $stmt = db()->query("SELECT * FROM faqs WHERE active = 1 ORDER BY sort_order ASC");
  $faqs = $stmt ? $stmt->fetchAll() : [];
} catch (Throwable $e) {
  $faqs = [];
}
// ----------------------

require __DIR__ . '/includes/header.php';
?>


  <!-- ===== HERO ===== -->
  <section class="hero hero--video">
    <video class="hero__video" autoplay muted loop playsinline preload="auto" poster="<?= asset('assets/hero.avif') ?>" aria-hidden="true">
      <source src="<?= asset('assets/hero-video.mp4') ?>" type="video/mp4">
    </video>
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <h1 class="hero__tagline">Your Trusted Digital Marketing Partner in Kerala</h1>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">We help brands shine beyond trends</h1>
          <p class="hero__desc">
            We empower businesses worldwide with result-driven digital marketing
            solutions that generate quality leads, boost revenue, and accelerate
            growth. Backed by 15+ years of experience, we deliver tailored
            strategies to help brands grow and succeed globally.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow btn--book" data-book-call>Book a Call</a>
          <?php /* <a href="<?= url('portfolio.php') ?>" class="btn btn--outline btn--arrow btn--works">View Our Works</a> */ ?>
        </div>
      </div>
    </div>
  </section>

    
  <!-- ===== ABOUT ===== -->
<section class="intro" id="about" data-nav="light">
  <div class="intro__inner">

    <div class="intro__left">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        About Us
      </span>
      <h2 class="intro__title">A Team of Passionate Experts Delivering Real Growth</h2>
    <a href="<?= url('about.php') ?>" class="btn btn--primary btn--sm btn--arrow">More About us</a>
    </div>

    <div class="intro__right">
      <p class="intro__text">
        TechBound is a digital marketing agency in Trivandrum, Kerala. We combine SEO,
        social media, paid advertising and web design to help businesses attract quality
        leads and grow revenue, whether you are starting out or scaling up.
      </p>

      <div class="stats">
        <div class="stat">
          <div class="stat__num"><span data-count="250">250</span><sup>+</sup></div>
          <p class="stat__label">Projects Completed</p>
        </div>
        <div class="stat">
          <div class="stat__num"><span data-count="15">15</span><sup>+</sup></div>
          <p class="stat__label">Years of Experience</p>
        </div>
        <div class="stat">
          <div class="stat__num"><span data-count="100">100</span><sup>+</sup></div>
          <p class="stat__label">Happy Clients</p>
        </div>
        <div class="stat">
          <div class="stat__num"><span data-count="25">25</span><sup>+</sup></div>
          <p class="stat__label">Talented Team</p>
        </div>
      </div>
    </div>

  </div>
</section>

  
  <!-- ===== SERVICES ===== -->
<section class="services" id="services" data-nav="light">
  <div class="services__inner">

    <div class="services__head">
      <span class="pill pill--glow" data-animate="up">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Services
      </span>
      <div class="services__row">
        <h2 class="services__title" data-animate="up">We help you scale with clear, proven services.</h2>
        <p class="services__lead" data-words>
  We offer a full range of digital services designed to help your
  business grow and thrive in a competitive landscape.
</p>
      </div>
    </div>

    <div class="services__grid">

      <article class="service-card" data-animate="up">
        <div class="service-card__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
        <h3 class="service-card__title">Search Engine Optimization (SEO)</h3>
        <p class="service-card__text">Increase your visibility on Google with technical SEO, on-page optimization, keyword research, and content strategies that drive qualified traffic.</p>
        <div class="service-card__tags">
          <span class="tag">Technical SEO</span>
          <span class="tag">Local SEO</span>
          <span class="tag">Ecommerce SEO</span>
        </div>
      </article>

      <article class="service-card" data-animate="up">
        <div class="service-card__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
        </div>
        <h3 class="service-card__title">Paid Advertising</h3>
        <p class="service-card__text">Launch high-performing campaigns across Google, Facebook, and Instagram to generate quality leads and maximize your return on investment.</p>
        <div class="service-card__tags">
          <span class="tag">Google Ads</span>
          <span class="tag">Meta Ads</span>
          <span class="tag">Performance Marketing</span>
        </div>
      </article>

      <article class="service-card" data-animate="up">
        <div class="service-card__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
        </div>
        <h3 class="service-card__title">Social Media Marketing</h3>
        <p class="service-card__text">Create engaging content, grow your audience, and turn followers into customers with strategic social media marketing.</p>
        <div class="service-card__tags">
          <span class="tag">Content Strategy</span>
          <span class="tag">Social Media Management</span>
          <span class="tag">Brand Growth</span>
        </div>
      </article>

      <article class="service-card" data-animate="up">
        <div class="service-card__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
        </div>
        <h3 class="service-card__title">Web Design &amp; Development</h3>
        <p class="service-card__text">Responsive, SEO-friendly websites designed to showcase your brand and convert visitors into customers.</p>
        <div class="service-card__tags">
          <span class="tag">Business Websites</span>
          <span class="tag">WordPress Development</span>
          <span class="tag">Custom Web Development</span>
        </div>
      </article>

      <article class="service-card" data-animate="up">
        <div class="service-card__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
        </div>
        <h3 class="service-card__title">Ecommerce Development</h3>
        <p class="service-card__text">Build secure, user-friendly ecommerce websites that provide seamless shopping experiences and higher conversions.</p>
        <div class="service-card__tags">
          <span class="tag">WooCommerce</span>
          <span class="tag">Shopify</span>
          <span class="tag">Custom Ecommerce</span>
        </div>
      </article>

      <article class="service-card" data-animate="up">
        <div class="service-card__icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
        </div>
        <h3 class="service-card__title">Digital Marketing Strategy</h3>
        <p class="service-card__text">From planning to execution, we create tailored digital marketing strategies based on your business goals and target audience.</p>
        <div class="service-card__tags">
          <span class="tag">Marketing Consulting</span>
          <span class="tag">Lead Generation</span>
          <span class="tag">Analytics &amp; Reporting</span>
        </div>
      </article>

    </div>
  </div>
</section>



  <!-- ===== TESTIMONIALS ===== -->
<section class="testimonials" id="testimonials">
  <div class="testimonials__inner">

    <div class="testimonials__heading">
      <span class="testimonials__eyebrow">Client Testimonials</span>
      <h2>What Our Clients Say</h2>
      <p>Real experiences. Meaningful results. Lasting partnerships.</p>
    </div>

    <?php
      $home_testimonials = [];
      try {
        require_once __DIR__ . '/includes/db.php';
        $tStmt = db()->query("SELECT quote, client, role FROM testimonials WHERE active = 1 ORDER BY sort_order ASC, id ASC");
        if ($tStmt) {
          $home_testimonials = $tStmt->fetchAll();
        }
      } catch (Throwable $e) {
        $home_testimonials = [];
      }
      if (empty($home_testimonials)) {
        $home_testimonials = [
          ['quote' => 'TechBound understood our goals and helped us strengthen our online presence.', 'client' => 'Client', 'role' => 'Digital Growth'],
          ['quote' => 'The team was professional, responsive and focused on delivering quality work.', 'client' => 'Client', 'role' => 'Web Development'],
          ['quote' => 'Our digital strategy became clearer, more consistent and better aligned with our goals.', 'client' => 'Client', 'role' => 'Marketing'],
          ['quote' => 'A supportive team that understands the importance of a strong brand.', 'client' => 'Client', 'role' => 'Brand Strategy'],
          ['quote' => 'The website looks modern, works smoothly and represents our business well.', 'client' => 'Client', 'role' => 'Website Design'],
          ['quote' => 'We appreciated the clear communication and attention to detail throughout the project.', 'client' => 'Client', 'role' => 'Digital Services'],
          ['quote' => 'The team worked with us to find practical solutions for our business.', 'client' => 'Client', 'role' => 'Business Growth'],
          ['quote' => 'A great experience from planning through execution and delivery.', 'client' => 'Client', 'role' => 'Project Delivery'],
        ];
      }
      $half = (int)ceil(count($home_testimonials) / 2);
      $top_reviews    = array_slice($home_testimonials, 0, $half);
      $bottom_reviews = array_slice($home_testimonials, $half);
      if (empty($bottom_reviews)) $bottom_reviews = $top_reviews;
    ?>

    <div class="testimonials__stage">

      <!-- Top row -->
      <div class="testimonial-row testimonial-row--top">
        <?php foreach ($top_reviews as $tr): ?>
        <article class="testimonial-card">
          <span class="testimonial-card__quote">“</span>
          <p><?= htmlspecialchars($tr['quote']) ?></p>
          <div class="testimonial-card__footer">
            <span><?= htmlspecialchars($tr['client'] ?: 'Client') ?></span>
            <strong><?= htmlspecialchars($tr['role'] ?: 'Client Review') ?></strong>
          </div>
        </article>
        <?php endforeach; ?>
      </div>

      <!-- Bottom row -->
      <div class="testimonial-row testimonial-row--bottom">
        <?php foreach ($bottom_reviews as $br): ?>
        <article class="testimonial-card">
          <span class="testimonial-card__quote">“</span>
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

  


  <!-- ===== PROCESS TIMELINE ===== -->
<section class="process" data-nav="light" id="process">
  <div class="services__inner">

    
    <div class="services__head">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Process
      </span>

      
    </div>
    
    <div class="process__timeline" id="processTimeline">
      <div class="process__line"><div class="process__fill" id="processFill"></div></div>
      <span class="process__dot" id="processDot"></span>

      <div class="process__step process__step--left">
        <div class="process__content">
          <h3>Discovery &amp; Strategy</h3>
          <p>We learn about your business, goals and audience, then shape a plan around them.</p>
        </div>
      </div>

      <div class="process__step process__step--right">
        <div class="process__content">
          <h3>Proposal &amp; Timeline</h3>
          <p>We agree on scope, pricing and clear timelines before any work begins.</p>
        </div>
      </div>

      <div class="process__step process__step--left">
        <div class="process__content">
          <h3>Design &amp; Execution</h3>
          <p>Our team builds your website, creatives and campaigns, with regular updates along the way.</p>
        </div>
      </div>

      <div class="process__step process__step--right">
        <div class="process__content">
          <h3>Review &amp; Refine</h3>
          <p>We refine everything based on your feedback until it matches your expectations.</p>
        </div>
      </div>

      <div class="process__step process__step--left">
        <div class="process__content">
          <h3>Launch &amp; Growth</h3>
          <p>We go live, track the results and keep optimising to grow your business.</p>
        </div>
      </div>
    </div>

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
              1. What services does TechBound provide?
            </button>
          </h3>
          <div class="faq__answer" id="faq-1">
            <div class="faq__answer-inner">
              <p>TechBound is a digital marketing agency in Trivandrum, Kerala. We help businesses grow with services such as SEO, social media marketing, paid advertising and web design.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-2">
              2. Do you work with businesses outside Kerala?
            </button>
          </h3>
          <div class="faq__answer" id="faq-2">
            <div class="faq__answer-inner">
              <p>Yes. We work with clients across India and abroad. Our projects are managed online, so location is not a barrier.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-3">
              3. How can TechBound help improve my brand's online visibility?
            </button>
          </h3>
          <div class="faq__answer" id="faq-3">
            <div class="faq__answer-inner">
              <p>We combine search optimization, content, social media and advertising into one plan built around your goals, so the right customers find you.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-4">
              4. How long does it take to see results?
            </button>
          </h3>
          <div class="faq__answer" id="faq-4">
            <div class="faq__answer-inner">
              <p>Paid campaigns can bring results within weeks, while SEO usually takes a few months to build. We share a timeline and regular reports from the start.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-5">
              5. How do I get started?
            </button>
          </h3>
          <div class="faq__answer" id="faq-5">
            <div class="faq__answer-inner">
              <p>Contact us by phone or email, tell us about your business, and we will set up a call to discuss the best plan for you.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

<section class="services blog" id="blog" data-nav="light">
  <div class="services__inner">

    <div class="services__head" data-animate="up">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Latest Articles
      </span>
      <div class="services__row">
        <h2 class="services__title">Fresh insights to help you grow online.</h2>
        <p class="services__lead">Practical updates on SEO, advertising and digital marketing from our team.</p>
      </div>
    </div>


    <?php
      $home_posts = [];
      try {
        require_once __DIR__ . '/includes/db.php';
        $stmt = db()->query("SELECT title, slug, category, image, published_at FROM blog_posts WHERE active = 1 ORDER BY published_at DESC, id DESC LIMIT 4");
        if ($stmt) {
          $home_posts = $stmt->fetchAll();
        }
      } catch (Throwable $e) {
        $home_posts = [];
      }

      if (empty($home_posts) && file_exists(__DIR__ . '/data/blogs_index.php')) {
        $all = require __DIR__ . '/data/blogs_index.php';
        if (is_array($all)) {
          $active = array_values(array_filter($all, fn($p) => ($p['active'] ?? 1) == 1));
          $home_posts = array_slice($active, 0, 4);
        }
      }
    ?>

    <div class="blog__grid">
      <?php if (!empty($home_posts)): ?>
        <?php foreach ($home_posts as $i => $hp):
          $postUrl   = url('blog-post.php?slug=' . rawurlencode($hp['slug'] ?? ''));
          $postImg   = blog_image_url($hp['image'] ?? '', $hp['category'] ?? null);
          $postTitle = htmlspecialchars($hp['title'] ?? '');
          $rawDate   = $hp['published_at'] ?? '';
          $ts        = $rawDate ? strtotime($rawDate) : false;
          $dateAttr  = $ts ? date('Y-m-d', $ts) : '';
          $dateLabel = $ts ? date('F j, Y', $ts) : '';
          $delay     = $i * 100;
        ?>
        <article class="blog-card" data-animate="up" style="--d:<?= $delay ?>ms">
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
      <?php else: ?>
        <article class="blog-card" data-animate="up" style="--d:0ms">
          <a href="<?= url('blog.php') ?>" class="blog-card__img">
            <img src="<?= asset('assets/blog-1.png') ?>" alt="ChatGPT Ads Are Going Visual" loading="lazy">
          </a>
          <div class="blog-card__body">
            <time class="blog-card__date" datetime="2026-10-12">October 12, 2026</time>
            <h3 class="blog-card__title"><a href="<?= url('blog.php') ?>">ChatGPT Ads Are Going Visual: What Advertisers Should Prepare For</a></h3>
            <a href="<?= url('blog.php') ?>" class="blog-card__more">Read More <span>→</span></a>
          </div>
        </article>

        <article class="blog-card" data-animate="up" style="--d:100ms">
          <a href="<?= url('blog.php') ?>" class="blog-card__img">
            <img src="<?= asset('assets/blog-2.png') ?>" alt="SEO Strategy and Technical SEO" loading="lazy">
          </a>
          <div class="blog-card__body">
            <time class="blog-card__date" datetime="2026-10-07">October 7, 2026</time>
            <h3 class="blog-card__title"><a href="<?= url('blog.php') ?>">SEO Strategy and Technical SEO in October 2026: What Changed and What to Do Next</a></h3>
            <a href="<?= url('blog.php') ?>" class="blog-card__more">Read More <span>→</span></a>
          </div>
        </article>

        <article class="blog-card" data-animate="up" style="--d:200ms">
          <a href="<?= url('blog.php') ?>" class="blog-card__img">
            <img src="<?= asset('assets/blog-3.png') ?>" alt="Meta Muse AI Agent" loading="lazy">
          </a>
          <div class="blog-card__body">
            <time class="blog-card__date" datetime="2026-10-05">October 5, 2026</time>
            <h3 class="blog-card__title"><a href="<?= url('blog.php') ?>">Meta Muse AI Agent: What It Does, How It Stays Private, and Why Marketers Should Care</a></h3>
            <a href="<?= url('blog.php') ?>" class="blog-card__more">Read More <span>→</span></a>
          </div>
        </article>

        <article class="blog-card" data-animate="up" style="--d:300ms">
          <a href="<?= url('blog.php') ?>" class="blog-card__img">
            <img src="<?= asset('assets/mega-blog.avif') ?>" alt="AI Search Visibility Guide" loading="lazy">
          </a>
          <div class="blog-card__body">
            <time class="blog-card__date" datetime="2026-10-01">October 1, 2026</time>
            <h3 class="blog-card__title"><a href="<?= url('blog.php') ?>">AI Search Visibility: How to Get Cited by ChatGPT, Perplexity and Google AI Overviews</a></h3>
            <a href="<?= url('blog.php') ?>" class="blog-card__more">Read More <span>→</span></a>
          </div>
        </article>
      <?php endif; ?>
    </div>

    <div class="blog__more">
  <a href="<?= url('blog.php') ?>" class="btn btn--primary btn--sm btn--arrow">
    Explore More
  </a>
</div>
  </div>
</section>


<!-- ========== CTA BANNER ========== -->
<section class="cta" data-nav="dark">
  <div class="cta__inner">
    <h2 class="cta__title">The Right Digital Partner Makes All the Difference.</h2>
    <p class="cta__lead">
      Whether you want more leads, better rankings or a website that actually converts,
      we'll help you find the right strategy and the right team to deliver it.
    </p>
    <div class="cta__actions">
      <a href="<?= url('contact.php') ?>" class="cta__btn cta__btn--solid" data-book-call>
        Book a Call
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
      <?php /* <a href="<?= url('portfolio.php') ?>" class="cta__btn cta__btn--ghost">View Our Work</a> */ ?>
    </div>
  </div>
</section>


<?php require __DIR__ . '/includes/footer.php'; ?>
   

 

  