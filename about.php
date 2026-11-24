<?php
$page_title   = 'About Us | TechBound Digital Marketing Agency Trivandrum';
$page_desc    = 'Learn about TechBound, a leading digital marketing agency in Trivandrum, Kerala. Meet our leadership team, discover our mission, and explore our 12+ years of delivering measurable growth.';
$page_styles  = ['css/about.css'];
$page_slug   = 'about';
$page_scripts = [
    'js/pages/about/mission.js',
    'js/pages/about/stats.js',
    'js/pages/about/who.js',
    'js/pages/about/journey.js',
    'js/pages/about/ceo.js',
    'js/pages/about/rotate.js'
    
];

require __DIR__ . '/includes/header.php';
?>

<main>

  <!-- ===== HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/about_hero.avif') ?>');">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">About Us</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Meet the Team Behind Your Growth</h1>
          <p class="hero__desc">
            With over 12 years of hands-on experience in Trivandrum, Kerala, we help ambitious brands outgrow trends with transparent, data-driven digital marketing and technology.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow">Work With Us</a>
          <a href="<?= url('careers.php') ?>" class="btn btn--outline btn--arrow">Join Our Team</a>
        </div>
      </div>
    </div>
  </section>
 
<section class="about-mv" data-nav="light">
  <div class="about-mv__inner mv-split">

    <div class="mv-col" data-animate>
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Mission
      </span>
      <h2 class="mv-col__title">Helping Businesses Grow Online, Every Step of the Way</h2>
      <p>
        To help businesses grow online by delivering result-driven digital
        marketing, creative design and reliable web solutions that attract
        quality leads and build lasting brands.
      </p>
    </div>

    <div class="mv-col" data-animate style="--d:150ms">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Vision
      </span>
      <h2 class="mv-col__title">Kerala's Most Trusted Digital Marketing Agency</h2>
      <p>
        To be Kerala's most trusted digital marketing agency, enabling every
        business we work with to reach its full potential through smart
        strategy and technology.
      </p>
    </div>

  </div>
</section>

<!-- Stats -->
<section class="about-stats" data-nav="light">

  <div class="about-stats__head" data-animate>
   <h2 class="about-stats__title">Counting Our Growing <span class="word-rotator" data-words="Success,Growth,Results,Impact"><span class="word-rotator__word">Success</span></span></h2>
    <p class="about-stats__lead">
      Our growing journey isn't just about these numbers. It's about our team,
      our clients, and the trust that drives us to deliver excellence and
      achieve greater success.
    </p>
  </div>

  <div class="about-stats__grid">
    <div class="about-stat" data-animate>
      <div class="about-stat__num"><span data-count="250">0</span><sup>+</sup></div>
      <p class="about-stat__label">Projects Completed</p>
    </div>
    <div class="about-stat" data-animate>
      <div class="about-stat__num"><span data-count="12">0</span><sup>+</sup></div>
      <p class="about-stat__label">Years of Experience</p>
    </div>
    <div class="about-stat" data-animate>
      <div class="about-stat__num"><span data-count="100">0</span><sup>+</sup></div>
      <p class="about-stat__label">Happy Clients</p>
    </div>
    <div class="about-stat" data-animate>
      <div class="about-stat__num"><span data-count="25">0</span><sup>+</sup></div>
      <p class="about-stat__label">Talented Team</p>
    </div>
  </div>
</section>

<!-- Who We Are -->
<section class="about-who" data-nav="light">
  <div class="about-who__inner">

    <div class="about-who__content" data-animate>
       <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Who We Are
      </span>
      <h2 class="about-who__title">A Team of Passionate Experts Delivering Real Growth</h2>

      <p>
        Techbound is a digital marketing agency based in Trivandrum, Kerala.
        We help businesses attract quality leads and grow revenue through
        strategies built around their goals, not a template.
      </p>
      <p>
        From SEO and paid advertising to web design and social media, our
        marketers, designers and developers work as one team so every
        campaign is creative, measurable and consistent.
      </p>

      <ul class="about-who__list">
        <li>Strategy backed by data</li>
        <li>Transparent reporting</li>
        <li>Dedicated support team</li>
        <li>Results you can measure</li>
      </ul>

      <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow btn--sm">Work With Us</a>
    </div>

    <div class="about-who__media" data-who-media>
  <div class="about-who__frame">
    <img src="<?= asset('assets/hero.avif') ?>" alt="The Techbound team at work" loading="lazy">
  </div>
  <div class="about-who__badge">
    <strong>12+</strong>
    <span>Years of Experience</span>
  </div>
</div>

  </div>
</section>

<!-- Our Leaders (CEO slider) -->
<section class="about-ceo">
  <div class="about-ceo__inner">

    <div class="about-ceo__head" data-animate>
      <div>
        <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Leaders
      </span>
        <h2 class="about-ceo__title">The People Leading Techbound</h2>
        <p class="about-ceo__lead">Meet the founders who started Techbound and still guide every project.</p>
      </div>

      <div class="ceo-nav">
        <button class="ceo-nav__btn" id="ceoPrev" aria-label="Previous leader">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <button class="ceo-nav__btn" id="ceoNext" aria-label="Next leader">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>
      </div>
    </div>

    <div class="ceo-viewport" id="ceoViewport">
      <div class="ceo-track" id="ceoTrack">

        <!-- CEO 1 -->
        <article class="ceo-slide">
          <div class="ceo-slide__photo">
            <img src="images/team/ceo-1.jpg" alt="CEO photo" loading="lazy">
          </div>
          <div class="ceo-slide__body">
            <div class="ceo-quote">
              <span class="ceo-quote__mark" aria-hidden="true">&ldquo;</span>
              <blockquote>
                We started Techbound to help local businesses grow online with honest advice,
                and that promise still guides every campaign we deliver.
              </blockquote>
              <h3>Riyaz Hakkim</h3>
              <span class="ceo-quote__role">Founder &amp; CEO, Techbound</span>
            </div>
            <div class="ceo-about">
              <span class="ceo-tag">Founder</span>
              <h4>Leading Techbound since 2009</h4>
              <p>Short line about this leader's background and focus, such as SEO, strategy or client success.</p>
             <a href="#" class="btn btn--primary btn--sm btn--arrow" target="_blank" rel="noopener">Connect on LinkedIn</a>
            </div>
          </div>
        </article>

        <!-- CEO 2 -->
        <article class="ceo-slide">
          <div class="ceo-slide__photo">
            <img src="images/team/ceo-2.jpg" alt="CEO photo" loading="lazy">
          </div>
          <div class="ceo-slide__body">
            <div class="ceo-quote">
              <span class="ceo-quote__mark" aria-hidden="true">&ldquo;</span>
              <blockquote>
                Great marketing is built on trust. We explain what we do, show the numbers
                and stay accountable to the results we promise.
              </blockquote>
              <h3>Shabna Nazeer</h3>
              <span class="ceo-quote__role">Co-founder &amp; CEO, Techbound</span>
            </div>
            <div class="ceo-about">
              <span class="ceo-tag">Co-founder</span>
              <h4>Building a trusted growth partner</h4>
              <p>Short line about this leader's background and focus, such as web, design or technology.</p>
              <a href="#" class="btn btn--primary btn--sm btn--arrow" target="_blank" rel="noopener">Connect on LinkedIn</a>
            </div>
          </div>
        </article>

      </div>
    </div>

    <div class="ceo-dots" id="ceoDots" aria-hidden="true"></div>

  </div>
</section>



<section class="process journey" data-nav="light" id="journey">
  <div class="services__inner">

    <div class="services__head">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Our Journey So Far
      </span>
      <div class="services__row">
        <h2 class="services__title">From a Small Team to a Trusted Growth Partner</h2>
      </div>
    </div>

    <div class="journey__scroller" id="journeyScroller">
      <div class="journey__timeline" id="journeyTimeline">
        <div class="journey__line"></div>
        <span class="journey__dot" id="journeyDot"></span>

        <div class="journey__step">
          <div class="journey__year">2009</div>
          <div class="journey__content">
            <h3>Where It Started</h3>
            <p>Techbound begins in Trivandrum with a small team and a big goal.</p>
          </div>
        </div>

        <div class="journey__step">
          <div class="journey__year">2012</div>
          <div class="journey__content">
            <h3>Growing the Team</h3>
            <p>New designers and developers join as client work grows.</p>
          </div>
        </div>

        <div class="journey__step">
          <div class="journey__year">2016</div>
          <div class="journey__content">
            <h3>Expanding Services</h3>
            <p>SEO, paid ads and social media join our web design services.</p>
          </div>
        </div>

        <div class="journey__step">
          <div class="journey__year">2020</div>
          <div class="journey__content">
            <h3>Going Fully Digital</h3>
            <p>We help businesses move online and keep growing through every change.</p>
          </div>
        </div>

        <div class="journey__step">
          <div class="journey__year">Today</div>
          <div class="journey__content">
            <h3>Growing Together</h3>
            <p>250+ projects delivered and 100+ happy clients, and counting.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
</section>




<?php
$faq_page  = 'about';
$faq_title = 'Common Questions About TechBound';
require __DIR__ . '/includes/faq-section.php';
?>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>