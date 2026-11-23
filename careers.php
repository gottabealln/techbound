<?php
$page_title   = "Careers at TechBound | Join Kerala's Leading Digital & Tech Agency";
$page_desc    = "Explore high-growth careers at TechBound in Trivandrum, Kerala. We are hiring SEO strategists, full-stack web developers, performance marketers, and creative designers.";
$page_styles  = ['css/careers.css'];
$page_scripts = ['js/pages/careers.js'];
$page_slug    = 'careers';

require __DIR__ . '/includes/header.php';
?>

<main>

  <!-- ===== HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/careers.avif') ?>');">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">Careers</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Build Your Career with Leaders in Digital &amp; Tech</h1>
          <p class="hero__desc">
            TechBound is Kerala's fast-growing digital agency. We are looking for ambitious thinkers, curious coders, growth hackers, and creative storytellers ready to lead major campaigns.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="#openings" class="btn btn--primary btn--arrow">View Openings</a>
          <a href="<?= url('about.php') ?>" class="btn btn--outline btn--arrow">About TechBound</a>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       QUICK INFO BAR
       ========================================================================= -->
  <div class="careers-quickbar">
    <div class="careers-quickbar__inner">
      <div class="careers-quickbar__item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
        <span>Location: <strong>Statue, Trivandrum (Kerala)</strong></span>
      </div>
      <div class="careers-quickbar__item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        <span>Schedule: <strong>Standard Hours &bull; Work-Life Balance</strong></span>
      </div>
      <div class="careers-quickbar__item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
        <span>Growth: <strong>Merit-Based Appraisals &amp; Mentorship</strong></span>
      </div>
      <div class="careers-quickbar__item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>Tech Stack: <strong>AI Tooling &amp; Enterprise Software</strong></span>
      </div>
    </div>
  </div>

  <!-- =========================================================================
       CULTURE & LIFE AT TECHBOUND
       ========================================================================= -->
  <section class="cr-section cr-culture" data-nav="light">
    <div class="cr-container">

      <div class="cr-culture__grid">

        <div class="cr-culture__image-wrap">
          <img class="cr-culture__image" src="<?= asset('assets/careers_photo.avif') ?>" alt="TechBound Team Members collaborating at Trivandrum office">
          <div class="cr-culture__badge-float">
            <div class="cr-culture__badge-stat">
              <strong>12+ Years</strong>
              <span>Digital Excellence in Kerala</span>
            </div>
            <div class="cr-culture__badge-stat">
              <strong>25+ Team</strong>
              <span>Strategists, Coders &amp; Creatives</span>
            </div>
            <div class="cr-culture__badge-stat">
              <strong>100%</strong>
              <span>Transparency &amp; On-Time Appraisals</span>
            </div>
          </div>
        </div>

        <div class="cr-culture__text-col">
          <span class="cr-pill">Life at TechBound</span>
          <h2 class="cr-title">A Workplace Designed for Autonomy, Creativity, and Growth</h2>
          <p>
            We've eliminated the micromanagement, corporate bureaucracy, and endless meetings that slow talented people down. At TechBound, you work with sharp, supportive colleagues who take pride in executing work at the highest standard.
          </p>
          <p>
            Whether you're crafting high-converting PPC funnels, diagnosing complex technical SEO frameworks, or writing full-stack code for high-traffic platforms, you own your outcomes and share directly in the team's wins.
          </p>

          <div class="cr-values-compact">
            <div class="cr-value-item">
              <div class="cr-value-item__num">01 / Ownership</div>
              <h4>High Agency &amp; Trust</h4>
              <p>Freedom to test fresh ideas, explore novel approaches, and take real responsibility.</p>
            </div>
            <div class="cr-value-item">
              <div class="cr-value-item__num">02 / Learning</div>
              <h4>Continuous Upskilling</h4>
              <p>Weekly knowledge teardowns, paid certifications, and enterprise tool access.</p>
            </div>
            <div class="cr-value-item">
              <div class="cr-value-item__num">03 / Balance</div>
              <h4>No Toxic Hustle</h4>
              <p>Sustainable pacing, clear client expectations, and deep respect for personal time.</p>
            </div>
            <div class="cr-value-item">
              <div class="cr-value-item__num">04 / Impact</div>
              <h4>High-Ticket Portfolios</h4>
              <p>Work directly on major brands in real estate, healthcare, education, and SaaS.</p>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       CURRENT OPENINGS BOARD
       ========================================================================= -->
  <section class="cr-section cr-openings" id="openings" data-nav="light">
    <div class="cr-container">

      <div class="cr-head">
        <span class="cr-pill">Join the Crew</span>
        <h2 class="cr-title">Current Open Positions</h2>
        <p class="cr-lead">
          Find your next career chapter. Select a department to explore live roles, view full role requirements, and submit your application.
        </p>
      </div>

      <!-- Category Filter Pills -->
      <div class="cr-filters">
        <button type="button" class="cr-filter-btn is-active" data-filter="all">All Roles <span>6</span></button>
        <button type="button" class="cr-filter-btn" data-filter="marketing">Digital Marketing &amp; SEO <span>2</span></button>
        <button type="button" class="cr-filter-btn" data-filter="engineering">Web &amp; Technology <span>1</span></button>
        <button type="button" class="cr-filter-btn" data-filter="creative">Design &amp; Creative <span>2</span></button>
        <button type="button" class="cr-filter-btn" data-filter="client">Strategy &amp; Accounts <span>1</span></button>
      </div>

      <!-- Job List -->
      <div class="cr-jobs-list">

        <!-- Job 1: Senior SEO Strategist -->
        <div class="cr-job-card" data-dept="marketing">
          <div class="cr-job-header">
            <div class="cr-job-info">
              <div class="cr-job-tags">
                <span class="cr-tag cr-tag--dept">Digital Marketing</span>
                <span class="cr-tag cr-tag--type">Full Time</span>
                <span class="cr-tag cr-tag--exp">2 - 5 Years Exp</span>
                <span class="cr-tag cr-tag--loc">Trivandrum (On-site/Hybrid)</span>
              </div>
              <h3 class="cr-job-title">Senior SEO Strategist</h3>
              <p class="cr-job-desc">
                Lead advanced organic growth strategies for enterprise clients across Kerala, Bangalore, and GCC markets. Architect content hubs, conduct technical site audits, and build sustainable rank-1 Google visibility.
              </p>
              <div class="cr-job-skills">
                <span class="cr-skill-pill">Technical SEO</span>
                <span class="cr-skill-pill">Ahrefs &amp; SEMrush</span>
                <span class="cr-skill-pill">Google Analytics 4</span>
                <span class="cr-skill-pill">Schema Markup</span>
                <span class="cr-skill-pill">Search Console</span>
              </div>
            </div>
            <div class="cr-job-actions">
              <button type="button" class="btn btn--outline js-toggle-details">View Details</button>
              <button type="button" class="btn btn--primary js-apply-role" data-role="Senior SEO Strategist">Apply Now</button>
            </div>
          </div>

          <div class="cr-job-drawer">
            <div class="cr-drawer-grid">
              <div class="cr-drawer-col">
                <h5>What You Will Own</h5>
                <ul>
                  <li>Conduct deep crawl and technical audits for large multi-page web applications.</li>
                  <li>Develop data-driven keyword maps, topical clusters, and editorial guidelines.</li>
                  <li>Perform competitive reverse-engineering to uncover high-intent organic gaps.</li>
                  <li>Track Core Web Vitals, indexation pipelines, and international hreflang tags.</li>
                  <li>Present monthly organic performance dashboards and strategic recommendations to clients.</li>
                </ul>
              </div>
              <div class="cr-drawer-col">
                <h5>What We Are Looking For</h5>
                <ul>
                  <li>2+ years of hands-on SEO agency or high-growth in-house experience.</li>
                  <li>Proven track record of ranking commercial competitive keywords on page 1.</li>
                  <li>Fluency in Screaming Frog, Ahrefs, Search Console, GA4, and Google Looker Studio.</li>
                  <li>Working knowledge of HTML, CSS, JavaScript rendering, and structured data.</li>
                  <li>Clear verbal and written communication skills with business stakeholders.</li>
                </ul>
              </div>
            </div>
            <div class="cr-drawer-apply-bar">
              <p>Ready to lead search growth for iconic brands? We’d love to speak with you.</p>
              <button type="button" class="btn btn--primary btn--sm js-apply-role" data-role="Senior SEO Strategist">Apply for this Role &rarr;</button>
            </div>
          </div>
        </div>

        <!-- Job 2: Performance Marketing Specialist -->
        <div class="cr-job-card" data-dept="marketing">
          <div class="cr-job-header">
            <div class="cr-job-info">
              <div class="cr-job-tags">
                <span class="cr-tag cr-tag--dept">Digital Marketing</span>
                <span class="cr-tag cr-tag--type">Full Time</span>
                <span class="cr-tag cr-tag--exp">1 - 4 Years Exp</span>
                <span class="cr-tag cr-tag--loc">Trivandrum</span>
              </div>
              <h3 class="cr-job-title">Performance Marketing Specialist (Google &amp; Meta Ads)</h3>
              <p class="cr-job-desc">
                Plan, launch, and optimize high-converting paid media campaigns. Manage monthly ad budgets with rigorous ROAS metrics, audience targeting, landing page testing, and conversion tracking.
              </p>
              <div class="cr-job-skills">
                <span class="cr-skill-pill">Google Ads</span>
                <span class="cr-skill-pill">Meta Ads Manager</span>
                <span class="cr-skill-pill">ROAS Optimization</span>
                <span class="cr-skill-pill">GTM &amp; CAPI</span>
                <span class="cr-skill-pill">A/B Testing</span>
              </div>
            </div>
            <div class="cr-job-actions">
              <button type="button" class="btn btn--outline js-toggle-details">View Details</button>
              <button type="button" class="btn btn--primary js-apply-role" data-role="Performance Marketing Specialist">Apply Now</button>
            </div>
          </div>

          <div class="cr-job-drawer">
            <div class="cr-drawer-grid">
              <div class="cr-drawer-col">
                <h5>What You Will Own</h5>
                <ul>
                  <li>Build and scale lead generation and eCommerce ad campaigns on Meta and Google.</li>
                  <li>Execute creative split-testing across hooks, visuals, ad copies, and CTAs.</li>
                  <li>Configure accurate Server-Side Conversions API, Pixel events, and GTM containers.</li>
                  <li>Analyze search term reports, negative keyword lists, and audience lookalikes.</li>
                  <li>Optimize cost-per-lead (CPL) and return-on-ad-spend (ROAS) across client portfolios.</li>
                </ul>
              </div>
              <div class="cr-drawer-col">
                <h5>What We Are Looking For</h5>
                <ul>
                  <li>1 to 4 years managing active paid campaigns with demonstrable results.</li>
                  <li>Comfort with analyzing numbers, calculating CAC/ROAS, and spotting conversion bottlenecks.</li>
                  <li>Google Ads / Meta Certified is a strong plus.</li>
                  <li>Strong collaboration mindset with copywriters and visual graphic designers.</li>
                </ul>
              </div>
            </div>
            <div class="cr-drawer-apply-bar">
              <p>Passionate about paid media and high-converting performance funnels?</p>
              <button type="button" class="btn btn--primary btn--sm js-apply-role" data-role="Performance Marketing Specialist">Apply for this Role &rarr;</button>
            </div>
          </div>
        </div>

        <!-- Job 3: Full-Stack Web Developer -->
        <div class="cr-job-card" data-dept="engineering">
          <div class="cr-job-header">
            <div class="cr-job-info">
              <div class="cr-job-tags">
                <span class="cr-tag cr-tag--dept">Web &amp; Technology</span>
                <span class="cr-tag cr-tag--type">Full Time</span>
                <span class="cr-tag cr-tag--exp">2 - 4 Years Exp</span>
                <span class="cr-tag cr-tag--loc">Trivandrum</span>
              </div>
              <h3 class="cr-job-title">Full-Stack Web Developer (PHP / Modern JS)</h3>
              <p class="cr-job-desc">
                Architect blazing-fast custom web applications, high-converting interactive landing pages, and clean database integrations. Optimize Core Web Vitals, REST APIs, and backend CMS dashboards.
              </p>
              <div class="cr-job-skills">
                <span class="cr-skill-pill">PHP 8+</span>
                <span class="cr-skill-pill">MySQL</span>
                <span class="cr-skill-pill">Modern JavaScript</span>
                <span class="cr-skill-pill">REST APIs</span>
                <span class="cr-skill-pill">Tailwind / CSS3</span>
                <span class="cr-skill-pill">Performance Tuning</span>
              </div>
            </div>
            <div class="cr-job-actions">
              <button type="button" class="btn btn--outline js-toggle-details">View Details</button>
              <button type="button" class="btn btn--primary js-apply-role" data-role="Full-Stack Web Developer">Apply Now</button>
            </div>
          </div>

          <div class="cr-job-drawer">
            <div class="cr-drawer-grid">
              <div class="cr-drawer-col">
                <h5>What You Will Own</h5>
                <ul>
                  <li>Develop lightweight, semantic, and high-performance websites and portal applications.</li>
                  <li>Build responsive UI components that achieve 90+ Google PageSpeed mobile scores.</li>
                  <li>Design clean relational database schemas and secure backend CRUD APIs.</li>
                  <li>Implement automated form validations, CRM integrations, and security protections.</li>
                  <li>Collaborate directly with designers to bring Figma designs to life with pixel perfection.</li>
                </ul>
              </div>
              <div class="cr-drawer-col">
                <h5>What We Are Looking For</h5>
                <ul>
                  <li>2+ years of professional web development in PHP, MySQL, JavaScript, and CSS.</li>
                  <li>Strong grasp of object-oriented PHP, PDO, prepared queries, and web security.</li>
                  <li>Experience building responsive, mobile-first layouts without bloated dependencies.</li>
                  <li>Familiarity with Git version control, Apache/Nginx configurations, and deployments.</li>
                </ul>
              </div>
            </div>
            <div class="cr-drawer-apply-bar">
              <p>Love shipping clean code and building web products that perform?</p>
              <button type="button" class="btn btn--primary btn--sm js-apply-role" data-role="Full-Stack Web Developer">Apply for this Role &rarr;</button>
            </div>
          </div>
        </div>

        <!-- Job 4: UI/UX & Graphic Designer -->
        <div class="cr-job-card" data-dept="creative">
          <div class="cr-job-header">
            <div class="cr-job-info">
              <div class="cr-job-tags">
                <span class="cr-tag cr-tag--dept">Design &amp; Creative</span>
                <span class="cr-tag cr-tag--type">Full Time</span>
                <span class="cr-tag cr-tag--exp">1 - 3 Years Exp</span>
                <span class="cr-tag cr-tag--loc">Trivandrum</span>
              </div>
              <h3 class="cr-job-title">UI/UX &amp; Graphic Designer</h3>
              <p class="cr-job-desc">
                Design stunning digital experiences, high-converting website layouts, brand identities, and eye-catching ad creatives that capture attention and elevate client brands.
              </p>
              <div class="cr-job-skills">
                <span class="cr-skill-pill">Figma</span>
                <span class="cr-skill-pill">UI/UX Prototyping</span>
                <span class="cr-skill-pill">Adobe Illustrator</span>
                <span class="cr-skill-pill">Photoshop</span>
                <span class="cr-skill-pill">Design Systems</span>
              </div>
            </div>
            <div class="cr-job-actions">
              <button type="button" class="btn btn--outline js-toggle-details">View Details</button>
              <button type="button" class="btn btn--primary js-apply-role" data-role="UI/UX & Graphic Designer">Apply Now</button>
            </div>
          </div>

          <div class="cr-job-drawer">
            <div class="cr-drawer-grid">
              <div class="cr-drawer-col">
                <h5>What You Will Own</h5>
                <ul>
                  <li>Wireframe and design modern website user interfaces in Figma with component variants.</li>
                  <li>Craft static and motion social media assets, ad banners, and infographics.</li>
                  <li>Develop brand guidelines, typography hierarchies, and cohesive color palettes.</li>
                  <li>Conduct heuristic usability evaluations and conversion flow enhancements.</li>
                </ul>
              </div>
              <div class="cr-drawer-col">
                <h5>What We Are Looking For</h5>
                <ul>
                  <li>A strong portfolio showcasing clean UI design, typography balance, and aesthetic taste.</li>
                  <li>Deep mastery of Figma (auto-layout, components, styles) and Adobe Creative Cloud.</li>
                  <li>Understanding of responsive design principles and mobile viewport constraints.</li>
                </ul>
              </div>
            </div>
            <div class="cr-drawer-apply-bar">
              <p>Have an eye for sleek visuals and interactive user flows? Join our design studio.</p>
              <button type="button" class="btn btn--primary btn--sm js-apply-role" data-role="UI/UX & Graphic Designer">Apply for this Role &rarr;</button>
            </div>
          </div>
        </div>

        <!-- Job 5: Content Writer & Copywriter -->
        <div class="cr-job-card" data-dept="creative">
          <div class="cr-job-header">
            <div class="cr-job-info">
              <div class="cr-job-tags">
                <span class="cr-tag cr-tag--dept">Design &amp; Creative</span>
                <span class="cr-tag cr-tag--type">Full Time</span>
                <span class="cr-tag cr-tag--exp">1 - 3 Years Exp</span>
                <span class="cr-tag cr-tag--loc">Trivandrum</span>
              </div>
              <h3 class="cr-job-title">Content Writer &amp; Copywriter</h3>
              <p class="cr-job-desc">
                Write persuasive conversion copy, high-ranking SEO content clusters, B2B case studies, and ad hooks that turn casual visitors into loyal customers for diverse industries.
              </p>
              <div class="cr-job-skills">
                <span class="cr-skill-pill">Conversion Copywriting</span>
                <span class="cr-skill-pill">SEO Content</span>
                <span class="cr-skill-pill">Brand Storytelling</span>
                <span class="cr-skill-pill">Social Scripts</span>
              </div>
            </div>
            <div class="cr-job-actions">
              <button type="button" class="btn btn--outline js-toggle-details">View Details</button>
              <button type="button" class="btn btn--primary js-apply-role" data-role="Content Writer & Copywriter">Apply Now</button>
            </div>
          </div>

          <div class="cr-job-drawer">
            <div class="cr-drawer-grid">
              <div class="cr-drawer-col">
                <h5>What You Will Own</h5>
                <ul>
                  <li>Draft engaging landing page copy, value propositions, and compelling calls-to-action.</li>
                  <li>Author in-depth, original SEO pillar guides that answer real search intent.</li>
                  <li>Write short-form social media ad copies and video reel scripts for Instagram and LinkedIn.</li>
                  <li>Interview client founders and technical teams to craft impactful success case studies.</li>
                </ul>
              </div>
              <div class="cr-drawer-col">
                <h5>What We Are Looking For</h5>
                <ul>
                  <li>Flawless English grammar, strong narrative voice, and persuasive writing skills.</li>
                  <li>Basic knowledge of keyword research and on-page SEO formatting.</li>
                  <li>Ability to break down complex technical topics into easy-to-read, punchy copy.</li>
                </ul>
              </div>
            </div>
            <div class="cr-drawer-apply-bar">
              <p>Love words that persuade, educate, and sell? Let’s create together.</p>
              <button type="button" class="btn btn--primary btn--sm js-apply-role" data-role="Content Writer & Copywriter">Apply for this Role &rarr;</button>
            </div>
          </div>
        </div>

        <!-- Job 6: Account Manager / Client Growth Lead -->
        <div class="cr-job-card" data-dept="client">
          <div class="cr-job-header">
            <div class="cr-job-info">
              <div class="cr-job-tags">
                <span class="cr-tag cr-tag--dept">Strategy &amp; Accounts</span>
                <span class="cr-tag cr-tag--type">Full Time</span>
                <span class="cr-tag cr-tag--exp">2 - 4 Years Exp</span>
                <span class="cr-tag cr-tag--loc">Trivandrum</span>
              </div>
              <h3 class="cr-job-title">Client Account Manager &amp; Growth Partner</h3>
              <p class="cr-job-desc">
                Be the trusted strategic partner for our key client accounts. Translate client business objectives into actionable agency roadmaps and manage ongoing communication and performance reviews.
              </p>
              <div class="cr-job-skills">
                <span class="cr-skill-pill">Account Strategy</span>
                <span class="cr-skill-pill">Client Relations</span>
                <span class="cr-skill-pill">Campaign Coordination</span>
                <span class="cr-skill-pill">Growth Roadmaps</span>
              </div>
            </div>
            <div class="cr-job-actions">
              <button type="button" class="btn btn--outline js-toggle-details">View Details</button>
              <button type="button" class="btn btn--primary js-apply-role" data-role="Client Account Manager">Apply Now</button>
            </div>
          </div>

          <div class="cr-job-drawer">
            <div class="cr-drawer-grid">
              <div class="cr-drawer-col">
                <h5>What You Will Own</h5>
                <ul>
                  <li>Serve as the primary liaison between key client stakeholders and internal delivery teams.</li>
                  <li>Run monthly strategy syncs, reporting transparent metrics and upcoming sprint initiatives.</li>
                  <li>Identify expansion opportunities where additional marketing channels can benefit the client.</li>
                  <li>Ensure deliverables, timelines, and campaign deadlines are met with high quality.</li>
                </ul>
              </div>
              <div class="cr-drawer-col">
                <h5>What We Are Looking For</h5>
                <ul>
                  <li>2+ years in an agency, SaaS, or client-facing digital marketing consulting role.</li>
                  <li>Strong understanding of digital marketing channels (SEO, Ads, Web, Social).</li>
                  <li>Exceptional communication, presentation, and relationship-building abilities.</li>
                </ul>
              </div>
            </div>
            <div class="cr-drawer-apply-bar">
              <p>Energized by building long-term partnerships and orchestrating digital victories?</p>
              <button type="button" class="btn btn--primary btn--sm js-apply-role" data-role="Client Account Manager">Apply for this Role &rarr;</button>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       OUR 4-STEP HIRING ROADMAP
       ========================================================================= -->
  <section class="cr-section cr-process" data-nav="light">
    <div class="cr-container">

      <div class="cr-head">
        <span class="cr-pill">Hiring Process</span>
        <h2 class="cr-title">Clear, Fast &amp; Transparent Recruitment</h2>
        <p class="cr-lead">
          We respect your time. Our hiring cycle typically wraps up in 5 to 7 business days, with timely feedback provided at every stage.
        </p>
      </div>

      <div class="cr-process-grid">

        <div class="cr-process-card">
          <div class="cr-step-num">01</div>
          <h3 class="cr-process-title">Application Review</h3>
          <p class="cr-process-text">
            Our department leads review your CV and portfolio within 48 hours to evaluate your experience and project work.
          </p>
        </div>

        <div class="cr-process-card">
          <div class="cr-step-num">02</div>
          <h3 class="cr-process-title">Introductory Chat</h3>
          <p class="cr-process-text">
            A 20-minute video or phone conversation to learn about your career goals, expectations, and culture alignment.
          </p>
        </div>

        <div class="cr-process-card">
          <div class="cr-step-num">03</div>
          <h3 class="cr-process-title">Practical Showcase</h3>
          <p class="cr-process-text">
            A small, realistic mini-task or portfolio walkthrough. No endless homework tests &mdash; just a look into how you think.
          </p>
        </div>

        <div class="cr-process-card">
          <div class="cr-step-num">04</div>
          <h3 class="cr-process-title">Offer &amp; Onboarding</h3>
          <p class="cr-process-text">
            We extend a transparent, competitive offer letter, walk you through perks, and welcome you to the TechBound team.
          </p>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       APPLICATION FORM SECTION (White-background Send Message interface)
       ========================================================================= -->
  <section class="cr-apply" id="apply" data-nav="light">
    <div class="cr-apply__inner" id="applyFormWrap">

      <!-- Left info -->
      <div class="cr-apply__info">
        <span class="pill pill--glow" data-animate="up">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Send Your Profile
        </span>
        <h2 class="cr-apply__title" data-animate="up" style="--d:80ms">Take the Next Step in Your Career Journey</h2>
        <p class="cr-apply__lead" data-animate="up" style="--d:160ms">
          Fill out the application form with your details. Whether you're applying for an open role or reaching out speculatively, our talent team will review your profile and respond promptly.
        </p>

        <?php
        $career_map_link = 'https://www.google.com/maps/search/?api=1&query=' . urlencode('TechBound Digital Marketing Agency Trivandrum, 6th Floor, Karimpanal Statue Avenue, Thiruvananthapuram 695001');
        ?>
        <ul class="cr-contact-list">
          <li data-animate="up" style="--d:240ms">
            <a href="tel:+918606497677">
              <span class="cr-contact-list__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
              </span>
              <span class="cr-contact-list__text"><small>Call us</small>+91 8606497677</span>
            </a>
          </li>
          <li data-animate="up" style="--d:320ms">
            <a href="mailto:contacts@techbound.in">
              <span class="cr-contact-list__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
              </span>
              <span class="cr-contact-list__text"><small>Email us</small>contacts@techbound.in</span>
            </a>
          </li>
          <li data-animate="up" style="--d:400ms">
            <a href="<?= $career_map_link ?>" target="_blank" rel="noopener" aria-label="Open TechBound location in Google Maps">
              <span class="cr-contact-list__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
              </span>
              <span class="cr-contact-list__text"><small>Visit us</small>6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, 695001</span>
            </a>
          </li>
          <li data-animate="up" style="--d:480ms">
            <div class="cr-contact-list__row">
              <span class="cr-contact-list__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              </span>
              <span class="cr-contact-list__text"><small>Working hours</small>Mon – Sat, 9:00 AM – 6:30 PM</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Right form -->
      <div class="cr-form-wrap" data-animate="up" style="--d:120ms">
        <h2 class="cr-form-title">Send your application</h2>

        <form id="careersForm" class="cr-form" action="send-career.php" method="POST" enctype="multipart/form-data" novalidate>

          <!-- Honeypot -->
          <div class="cr-trap" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="cr-field">
            <input type="text" id="cr-name" name="name" placeholder=" " autocomplete="name" required>
            <label for="cr-name">Full Name</label>
          </div>

          <div class="cr-field">
            <input type="email" id="cr-email" name="email" placeholder=" " autocomplete="email" required>
            <label for="cr-email">Email Address</label>
          </div>

          <div class="cr-form__phone">
            <div class="cr-field cr-field--code">
              <input type="text" id="cr-code" name="code" value="+91" aria-label="Country code">
            </div>
            <div class="cr-field">
              <input type="tel" id="cr-phone" name="phone" placeholder=" " autocomplete="tel-national" required>
              <label for="cr-phone">Phone Number</label>
            </div>
          </div>

          <div class="cr-field">
            <select id="cr-role" name="role" required>
              <option value="" selected>Select Position</option>
              <option value="Senior SEO Strategist">Senior SEO Strategist</option>
              <option value="Performance Marketing Specialist">Performance Marketing Specialist</option>
              <option value="Full-Stack Web Developer">Full-Stack Web Developer</option>
              <option value="UI/UX & Graphic Designer">UI/UX &amp; Graphic Designer</option>
              <option value="Content Writer & Copywriter">Content Writer &amp; Copywriter</option>
              <option value="Client Account Manager">Client Account Manager</option>
              <option value="Digital Marketing Trainee">Digital Marketing Trainee (Fresher)</option>
              <option value="Speculative / General Application">Speculative / Other</option>
            </select>
            <label for="cr-role">Role of Interest</label>
          </div>

          <div class="cr-field">
            <select id="cr-experience" name="experience" required>
              <option value="" selected>Select Experience</option>
              <option value="Fresh Graduate / Entry Level">Fresh Graduate / Entry Level</option>
              <option value="1 - 2 Years">1 - 2 Years</option>
              <option value="2 - 4 Years">2 - 4 Years</option>
              <option value="4+ Years (Senior / Lead)">4+ Years (Senior / Lead)</option>
            </select>
            <label for="cr-experience">Experience Level</label>
          </div>

          <div class="cr-field">
            <input type="url" id="cr-portfolio" name="portfolio" placeholder=" ">
            <label for="cr-portfolio">Portfolio / LinkedIn URL (Optional)</label>
          </div>

          <!-- Resume file upload box -->
          <div class="cr-upload-field">
            <span class="cr-upload-label">Upload Resume / CV <span class="opt">(PDF, DOC, DOCX &bull; Max 8MB)</span></span>
            <div class="cr-upload-box">
              <input type="file" id="cr-resume" name="resume" accept=".pdf,.doc,.docx,.rtf">
              <div class="cr-upload-content">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                <span class="cr-upload-text"><strong>Choose file</strong> or drag &amp; drop your resume here</span>
                <span class="cr-upload-hint">Accepted formats: PDF, DOC, DOCX up to 8MB</span>
              </div>
              <div class="cr-upload-name"></div>
            </div>
          </div>

          <div class="cr-field">
            <textarea id="cr-message" name="message" rows="3" placeholder=" "></textarea>
            <label for="cr-message">Cover Note / Why TechBound? (Optional)</label>
          </div>

          <p class="cr-form__note">
            By sending this form I confirm that I have read and accept Techbound's
            <a href="privacy-policy.php">privacy policy</a>.
          </p>

          <button type="submit" id="careerSubmitBtn" class="btn btn--primary btn--sm btn--arrow cr-submit-btn">
            Submit Application
          </button>

          <p id="careerStatus" class="cr-status" role="status" aria-live="polite"></p>

        </form>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       FREQUENTLY ASKED QUESTIONS
       ========================================================================= -->
  <section class="faq" id="faq" data-nav="light">
    <div class="faq__inner">
      <h2 class="faq__title">Frequently Asked Questions</h2>

      <div class="faq__list">

        <div class="faq__item is-open">
          <h3>
            <button class="faq__question" type="button" aria-expanded="true" aria-controls="faq-1">
              1. Where is the office located and what are the working hours?
            </button>
          </h3>
          <div class="faq__answer" id="faq-1">
            <div class="faq__answer-inner">
              <p>Our studio is located on the 6th Floor, Karimpanal Statue Avenue, Opposite the Secretariat, Statue, Thiruvananthapuram. Our standard business hours are 9:00 AM to 6:00 PM, Monday through Friday, with alternate Saturdays. We focus on clear goals and output rather than micromanaging minutes.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-2">
              2. Can fresh graduates apply for trainee positions at TechBound?
            </button>
          </h3>
          <div class="faq__answer" id="faq-2">
            <div class="faq__answer-inner">
              <p>Yes! We actively welcome energetic freshers with high drive and curiosity. Through our digital marketing and web development trainee tracks, you work directly under senior strategists and get hands-on experience on live client accounts from day one.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-3">
              3. Do you offer remote or hybrid work options?
            </button>
          </h3>
          <div class="faq__answer" id="faq-3">
            <div class="faq__answer-inner">
              <p>We believe high-velocity creative collaboration and rapid peer mentorship thrive best in-person at our Trivandrum office. However, we offer hybrid flexibility for senior roles, along with planned remote working days when needed.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-4">
              4. How fast can I expect to hear back after submitting my application?
            </button>
          </h3>
          <div class="faq__answer" id="faq-4">
            <div class="faq__answer-inner">
              <p>Our hiring team reviews applications within 48 to 72 business hours. If your profile matches our requirements, we will reach out via WhatsApp or phone to schedule an introductory discovery conversation.</p>
            </div>
          </div>
        </div>

        <div class="faq__item">
          <h3>
            <button class="faq__question" type="button" aria-expanded="false" aria-controls="faq-5">
              5. What should I do if my exact skill set is not listed in current openings?
            </button>
          </h3>
          <div class="faq__answer" id="faq-5">
            <div class="faq__answer-inner">
              <p>You can submit a speculative application using the form above by selecting "Speculative / Other" or email your resume and portfolio directly to <a href="mailto:contacts@techbound.in">contacts@techbound.in</a>. We are always happy to meet high-drive performers.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- =========================================================================
       SPECULATIVE / BOTTOM CALL TO ACTION
       ========================================================================= -->
  <section class="cr-bottom-cta" data-nav="dark">
    <div class="cr-container">
      <div class="cr-bottom-cta__inner">
        <h3>Don’t See Your Exact Role?</h3>
        <p>
          We are always searching for exceptional minds in marketing, coding, sales, and design. Drop us an open application and let’s talk about creating a role for you.
        </p>
        <div class="cr-bottom-cta__actions">
          <a class="btn btn--primary js-apply-role" data-role="Speculative / General Application" href="#apply">Submit Open Application</a>
          <a class="btn btn--outline" href="mailto:contacts@techbound.in">Email Us: contacts@techbound.in</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
