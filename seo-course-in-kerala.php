<?php
$page_title  = 'SEO Course in Kerala with AI, AEO & GEO | TechBound';
$page_desc   = 'Learn SEO, AEO and GEO for AI search with an agency internship on live client websites. Online & offline batches, Malayalam support. Book a free demo.';
$page_styles = ['css/course.css'];
$page_slug   = 'seo-course-in-kerala';

$schema_data = json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'Course',
            'name'        => 'AI 360 SEO Course',
            'description' => 'SEO course covering technical, on-page and local SEO, Answer Engine Optimization (AEO) and Generative Engine Optimization (GEO), with an agency internship on live client projects.',
            'provider'    => [
                '@type' => 'EducationalOrganization',
                'name'  => 'TechBound Digital Innovations',
                'url'   => 'https://techbound.in',
            ],
            'inLanguage'  => ['en', 'ml'],
            'teaches'     => [
                'Search Engine Optimization',
                'Technical SEO',
                'Local SEO',
                'Answer Engine Optimization',
                'Generative Engine Optimization',
                'Google AI Overviews optimization',
            ],
            'hasCourseInstance' => [
                [
                    '@type'      => 'CourseInstance',
                    'courseMode' => 'Onsite',
                    'location'   => [
                        '@type'   => 'Place',
                        'address' => '6th Floor, Karimpanal Statue Avenue, Statue, Thiruvananthapuram, Kerala 695001',
                    ],
                ],
                [
                    '@type'      => 'CourseInstance',
                    'courseMode' => 'Online',
                ],
            ],
        ],
        [
            '@type'        => ['EducationalOrganization', 'LocalBusiness'],
            'name'         => 'TechBound Digital Innovations',
            'url'          => 'https://techbound.in',
            'telephone'    => '+91-7736560333',
            'email'        => 'office@techbound.in',
            'address'      => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => '6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue',
                'addressLocality' => 'Thiruvananthapuram',
                'addressRegion'   => 'Kerala',
                'postalCode'      => '695001',
                'addressCountry'  => 'IN',
            ],
            'areaServed'   => 'Kerala, India',
            'foundingDate' => '2009',
        ],
        [
            '@type'      => 'FAQPage',
            'mainEntity' => [
                ['@type' => 'Question', 'name' => 'Is SEO replaced by AI?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'No. AI changed where people search, not whether businesses need to be found. AI Overviews, ChatGPT and Gemini build answers from websites, so brands still need SEO, plus AEO and GEO to be quoted in those answers. This course teaches all three.']],
                ['@type' => 'Question', 'name' => 'What is the difference between SEO, AEO and GEO?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'SEO helps a website rank in search results. AEO (Answer Engine Optimization) helps it become the direct answer in featured snippets, People Also Ask and voice search. GEO (Generative Engine Optimization) helps a brand get mentioned and cited by AI assistants like ChatGPT, Gemini and Perplexity.']],
                ['@type' => 'Question', 'name' => 'Can I learn SEO in 3 months?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'You can learn the core skills in about three months of regular practice. Becoming job-ready takes that plus hands-on work on real websites, which is why the course includes an agency internship.']],
                ['@type' => 'Question', 'name' => 'What is the fee for the AI 360 SEO course?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'The course fee is shared with instalment options. It covers training, the agency internship, tools access and the certificate. Ask us on WhatsApp for the full fee breakdown.']],
                ['@type' => 'Question', 'name' => 'Can I join after plus-two?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes. You need basic computer skills and good reading in English. Classes include Malayalam explanations.']],
                ['@type' => 'Question', 'name' => 'Is the course online or offline?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Both. Join at our office or attend live online classes, with weekday and weekend batches. Recordings are available if you miss a session.']],
                ['@type' => 'Question', 'name' => 'Do you offer placement?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'We offer placement support: portfolio building, mock interviews, CV help and referrals to hiring partners. We do not promise 100% placement; we prepare you so your work speaks for you.']],
                ['@type' => 'Question', 'name' => 'Will I get a certificate?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes, a TechBound course and internship certificate. Your portfolio of real projects will matter more to employers than any certificate, so we help you build both.']],
                ['@type' => 'Question', 'name' => 'Which SEO tools will I learn?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Google Search Console, Google Analytics 4, Looker Studio, Screaming Frog, PageSpeed Insights, Ahrefs or Semrush, and AI tools such as ChatGPT and Gemini for research and content workflows.']],
                ['@type' => 'Question', 'name' => 'Can I freelance after this course?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Yes. SEO is one of the easiest digital skills to freelance. The course covers pricing, proposals and client handling, and your internship projects become your first case studies.']],
                ['@type' => 'Question', 'name' => 'I run a business. Is there a shorter option?', 'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Ask us about the one-to-one track for business owners who want to manage their own SEO or check an agency\'s work.']],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

require __DIR__ . '/includes/header.php';
?>

<main>

  <!-- ===== 1. HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/course-hero.jpg') ?>');" data-nav="dark">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">AI 360 SEO Course &middot; Agency Internship Included</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Stop Learning Only Theory. Start Ranking Real Websites, on Google and Inside AI Answers.</h1>
          <p class="hero__desc">
            Learn SEO, AEO and GEO inside a working digital marketing agency. You'll optimise live client websites, get your work seen in Google, ChatGPT, Gemini and Perplexity, and leave with a portfolio employers can check.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="#enquire" class="btn btn--primary btn--arrow" data-cta="cta1_demo">Book a Free Demo Class</a>
          <a href="tel:+917736560333" class="btn btn--outline btn--arrow">Call Us</a>
        </div>

        <p style="margin-top:14px;font-size:14px;color:rgba(255,255,255,.78);">
          60-minute live session. See how we audit a real website for Google and AI search. No payment, no pressure.
        </p>
      </div>
    </div>
  </section>

  <!-- ===== SUMMARY + TRUST TILES ===== -->
  <section class="crs-section" style="padding-top:56px;padding-bottom:64px;" data-nav="light">
    <div class="crs-wrap">
      <p class="crs-answer" style="margin-top:0;">
        <strong>In short:</strong> TechBound's AI 360 SEO course teaches search engine optimisation the way agencies practise it today: technical SEO, content and local SEO, plus Answer Engine Optimization (AEO) and Generative Engine Optimization (GEO) for AI search. Classes run online and offline, in English with Malayalam support, and every learner completes an agency internship on real client projects.
      </p>

      <div class="crs-trust">
        <div class="crs-trust__item">
          <strong>Since 2009</strong>
          <span>Delivering digital marketing</span>
        </div>
        <div class="crs-trust__item">
          <strong>6+ Countries</strong>
          <span>Clients served by our agency</span>
        </div>
        <div class="crs-trust__item">
          <strong>Agency Internship</strong>
          <span>On live client websites</span>
        </div>
        <div class="crs-trust__item">
          <strong>Online &amp; Offline</strong>
          <span>Weekday &amp; weekend batches</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== 2. HOOK: IS SEO DEAD? ===== -->
  <section class="crs-section crs-section--dark" id="why" data-nav="dark">
    <div class="crs-wrap">
      <div class="crs-head crs-head--left">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          The Question Everyone Asks
        </span>
        <h2 class="crs-title">Is SEO dead? <em>No. It moved.</em></h2>
        <p class="crs-lead">
          You've probably seen the reels. "AI will replace SEO." "Nobody clicks Google anymore." Here's what actually happened. People still search; they just search in more places. A student asks ChatGPT which course to take. A parent checks Google's AI Overview for fees. A shop owner asks Gemini for the best clinic nearby. Each of those answers is built from websites. Someone has to make sure the right website is the one being quoted.
        </p>
      </div>

      <h3 style="font-family:var(--font-heading);font-size:21px;font-weight:500;color:#fff;margin:0 0 12px;">The three layers of modern search</h3>
      <div class="crs-layers">
        <article class="crs-layer">
          <div class="crs-layer__tag">SEO</div>
          <div class="crs-layer__goal">Search Engine Optimization: Get found</div>
          <ul>
            <li><strong>Where:</strong> Google &amp; Bing results, map pack</li>
            <li><strong>You work on:</strong> keywords, technical health, content, links</li>
            <li><strong>Measured by:</strong> rankings, clicks, leads</li>
          </ul>
        </article>
        <article class="crs-layer">
          <div class="crs-layer__tag">AEO</div>
          <div class="crs-layer__goal">Answer Engine Optimization: Become the answer</div>
          <ul>
            <li><strong>Where:</strong> featured snippets, People Also Ask, voice answers</li>
            <li><strong>You work on:</strong> question-led content, FAQ structure, schema</li>
            <li><strong>Measured by:</strong> snippet wins, PAA presence</li>
          </ul>
        </article>
        <article class="crs-layer">
          <div class="crs-layer__tag">GEO</div>
          <div class="crs-layer__goal">Generative Engine Optimization: Get mentioned</div>
          <ul>
            <li><strong>Where:</strong> Google AI Overviews, ChatGPT, Gemini, Perplexity, Copilot</li>
            <li><strong>You work on:</strong> entities, brand mentions, citable facts, topical authority</li>
            <li><strong>Measured by:</strong> AI citations and brand mentions</li>
          </ul>
        </article>
      </div>

      <p class="crs-closing">Most courses still teach only the first layer. This one teaches all three, on real websites.</p>
    </div>
  </section>

  <!-- ===== 3. PERSONAS ===== -->
  <section class="crs-section" id="for-you" data-nav="light">
    <div class="crs-wrap">
      <div class="crs-head">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Three People, Three Worries, One Course
        </span>
        <h2 class="crs-title">Which of these sounds like you?</h2>
        <p class="crs-lead">Everyone who calls us brings a different worry. These are the three we hear most, and what we do about each.</p>
      </div>

      <div class="crs-tabs" role="tablist">
        <button type="button" class="crs-tab" role="tab" aria-selected="true" aria-controls="crs-p1" id="crs-t1">"I need a job, not another certificate"</button>
        <button type="button" class="crs-tab" role="tab" aria-selected="false" aria-controls="crs-p2" id="crs-t2">"Will AI take this job before I get it?"</button>
        <button type="button" class="crs-tab" role="tab" aria-selected="false" aria-controls="crs-p3" id="crs-t3">"Will this fit my life, and is it real?"</button>
      </div>

      <!-- Persona 1 -->
      <div class="crs-panel is-active" role="tabpanel" id="crs-p1" aria-labelledby="crs-t1">
        <div class="crs-panel__story">
          <div class="crs-panel__who">Arjun, 23</div>
          <div class="crs-panel__role">Fresh graduate</div>
          <p>Arjun finished his BCom last year. His parents are ready to pay for a course, but the last three institutes he visited all said "100% placement" and none could show him a single student's work. He's scrolled enough reels to know a promise isn't proof.</p>
          <div class="crs-panel__worry">"Will I actually be job-ready, or will I just get a certificate and a list of job links?"</div>
        </div>
        <div class="crs-panel__fix">
          <h3>What changes at TechBound</h3>
          <ul class="crs-ticks">
            <li>You learn inside an agency, not a classroom. The same team that runs SEO for paying clients teaches you.</li>
            <li>From month two you work on live client websites during your agency internship: audits, keyword maps, content briefs, Google Business Profile optimisation.</li>
            <li>You leave with a portfolio (before/after audits, ranking reports, and a GEO visibility report) that an interviewer can open and check.</li>
            <li>Mock interviews and portfolio reviews with the people who hire SEO executives.</li>
          </ul>
          <p class="crs-proof">Ask us to see a sample learner portfolio and the internship project list during your demo class.</p>
        </div>
      </div>

      <!-- Persona 2 -->
      <div class="crs-panel" role="tabpanel" id="crs-p2" aria-labelledby="crs-t2">
        <div class="crs-panel__story">
          <div class="crs-panel__who">Rahul, 29</div>
          <div class="crs-panel__role">Career switcher from sales</div>
          <p>Rahul has spent five years in sales. He's good with people and numbers, but he wants a skill that grows. Every time he looks at SEO, someone online says ChatGPT will make it pointless.</p>
          <div class="crs-panel__worry">"Why switch into a field AI is about to replace?"</div>
        </div>
        <div class="crs-panel__fix">
          <h3>What changes at TechBound</h3>
          <p style="font-family:var(--font-body);font-size:15.5px;color:#3d4a44;margin:0 0 12px;">AI is in the syllabus from week one, as a working tool and as a new search channel you'll optimise for. You'll learn exactly where AI helps and where a human is still needed.</p>
          <div class="crs-mini-table-wrap">
            <table class="crs-mini-table">
              <thead><tr><th>Task</th><th>What AI does well</th><th>What you still own</th></tr></thead>
              <tbody>
                <tr><td>Keyword research</td><td>Expands lists, groups topics fast</td><td>Picking keywords that bring paying customers</td></tr>
                <tr><td>Content</td><td>Drafts outlines and first versions</td><td>Facts, experience, local insight, final quality</td></tr>
                <tr><td>Technical SEO</td><td>Flags issues in crawl data</td><td>Deciding what to fix first and getting it fixed</td></tr>
                <tr><td>AI search visibility</td><td>Gives the answers</td><td>Making sure your client's brand is the one cited</td></tr>
                <tr><td>Reporting</td><td>Summarises numbers</td><td>Explaining results and planning next month</td></tr>
              </tbody>
            </table>
          </div>
          <p class="crs-proof">In the demo class we show how an AI Overview and ChatGPT answer a real search, and what changes when a site is optimised.</p>
        </div>
      </div>

      <!-- Persona 3 -->
      <div class="crs-panel" role="tabpanel" id="crs-p3" aria-labelledby="crs-t3">
        <div class="crs-panel__story">
          <div class="crs-panel__who">Divya, 34</div>
          <div class="crs-panel__role">Returning after a career break</div>
          <p>Divya left her job after her second child. Now she wants work she can grow into, ideally with flexible hours. Her feed is full of "earn &#8377;2 lakh from home" ads, and she trusts none of them.</p>
          <div class="crs-panel__worry">"Can I learn this around my family, and will anyone hire me after a break?"</div>
        </div>
        <div class="crs-panel__fix">
          <h3>What changes at TechBound</h3>
          <ul class="crs-ticks">
            <li>Weekend and online batches, with recorded sessions if you miss a class.</li>
            <li>Taught in English with Malayalam explanations whenever you need them.</li>
            <li>Small batches, so your mentor knows your name and your progress.</li>
            <li>Honest numbers: freshers in SEO usually start between &#8377;15,000 and &#8377;30,000 a month. Growth comes from skill and a portfolio, not a certificate. We tell you that before you pay, not after.</li>
            <li>SEO suits remote and freelance work. Your internship projects become your first case studies.</li>
          </ul>
        </div>
      </div>

      <p class="crs-persona-close">Three different starting points. One skill that every business with a website now needs.</p>
    </div>
  </section>

  <!-- ===== 4. WHAT YOU'LL LEARN ===== -->
  <section class="crs-section crs-section--tint" id="learn" data-nav="light">
    <div class="crs-wrap">
      <div class="crs-head">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Skills You'll Build
        </span>
        <h2 class="crs-title">What will you learn in the AI 360 SEO course?</h2>
        <p class="crs-answer">
          You'll learn the full SEO course (keyword research, on-page, technical, off-page, and local SEO) plus AI search skills most courses skip: Answer Engine Optimization for snippets and voice, and Generative Engine Optimization for AI Overviews, ChatGPT, Gemini and Perplexity. Every module ends with work on a live website.
        </p>
      </div>

      <div class="crs-cards">
        <div class="crs-card"><span class="crs-card__badge">01</span><h3>Search Fundamentals</h3><p>How Google crawls, indexes and ranks pages, and how AI assistants pick sources.</p></div>
        <div class="crs-card"><span class="crs-card__badge">02</span><h3>Keyword &amp; Intent Research</h3><p>Find what customers search, group it by intent, and choose what to rank for.</p></div>
        <div class="crs-card"><span class="crs-card__badge">03</span><h3>On-Page &amp; Content SEO</h3><p>Titles, headings, internal links and content briefs that rank and convert.</p></div>
        <div class="crs-card"><span class="crs-card__badge">04</span><h3>Technical SEO</h3><p>Site audits, Core Web Vitals, sitemaps, schema and indexing fixes.</p></div>
        <div class="crs-card"><span class="crs-card__badge">05</span><h3>Local SEO</h3><p>Google Business Profile, map pack, reviews and local landing pages.</p></div>
        <div class="crs-card"><span class="crs-card__badge">AEO</span><h3>AEO: Become the Answer</h3><p>Win featured snippets, People Also Ask and voice answers.</p></div>
        <div class="crs-card"><span class="crs-card__badge">GEO</span><h3>GEO: Get Mentioned in AI</h3><p>Get brands cited in AI Overviews, ChatGPT, Gemini and Perplexity.</p></div>
        <div class="crs-card"><span class="crs-card__badge">08</span><h3>Analytics &amp; Reporting</h3><p>Search Console, GA4 and Looker Studio reports clients understand.</p></div>
      </div>

      <div class="crs-details">
        <div><small>Duration</small><strong>6 Months (with Internship)</strong></div>
        <div><small>Mode</small><strong>Online &amp; Offline</strong></div>
        <div><small>Batches</small><strong>Weekday &amp; Weekend</strong></div>
        <div><small>Language</small><strong>English + Malayalam support</strong></div>
        <div><small>Includes</small><strong>Agency internship + certificate</strong></div>
      </div>
    </div>
  </section>

  <!-- ===== CURRICULUM ===== -->
  <section class="crs-section" id="curriculum" data-nav="light">
    <div class="crs-wrap">
      <div class="crs-head">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Full SEO Course Syllabus
        </span>
        <h2 class="crs-title">AI 360 SEO Course Curriculum</h2>
        <p class="crs-lead">Fifteen modules, from search basics to AI visibility, ending with an agency internship and capstone.</p>
      </div>

      <div class="crs-acc" id="crsAcc">
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">01</span>Introduction to Search</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>How search engines and AI answer engines work; SERP features; the SEO &middot; AEO &middot; GEO model.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">02</span>Keyword Research with AI</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Search intent, keyword mapping, topic clusters, using ChatGPT and Gemini for research, validating with real data.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">03</span>On-Page SEO</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Title tags, meta descriptions, headings, URL structure, internal linking, image SEO.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">04</span>Content Strategy &amp; AI-Friendly Content</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Briefs, E-E-A-T, topical authority, writing with AI without publishing AI fluff.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">05</span>Technical SEO</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Site architecture, crawling and indexing, XML sitemaps, robots.txt, canonicals, Core Web Vitals, mobile-first, site audits with Screaming Frog.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">06</span>Structured Data &amp; Schema</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>FAQ, Organization, LocalBusiness, Product, Course and Article schema; testing and validation.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">07</span>Off-Page SEO &amp; Digital PR</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Quality link building, brand mentions, citations, outreach that isn't spam.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">08</span>Local SEO</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Google Business Profile, reviews, NAP consistency, local landing pages, map pack ranking.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">09</span>Answer Engine Optimization (AEO)<span class="crs-acc__tag">AI SEARCH</span></span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Question research, featured snippets, People Also Ask, voice search, zero-click strategy.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">10</span>Generative Engine Optimization (GEO)<span class="crs-acc__tag">AI SEARCH</span></span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>How AI Overviews, ChatGPT, Gemini, Perplexity and Copilot choose sources; entity SEO; making content citable; tracking AI visibility.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">11</span>SEO for Ecommerce &amp; WordPress</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Product and category pages, Shopify and WordPress SEO basics.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">12</span>Analytics &amp; Reporting</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Google Search Console, GA4, Looker Studio dashboards, reporting to clients.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">13</span>SEO Tools Lab</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Search Console, GA4, Screaming Frog, Ahrefs or Semrush, PageSpeed Insights, AI tools.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">14</span>Freelancing &amp; Client Handling</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Pricing, proposals, audits that win clients, communication.</p></div></div>
        <div class="crs-acc__item"><button type="button" class="crs-acc__btn" aria-expanded="false"><span><span class="crs-acc__num">15</span>Agency Internship &amp; Capstone</span><span class="crs-acc__plus">+</span></button><div class="crs-acc__body"><p>Live client projects, a full SEO + GEO audit of a real website, portfolio and interview prep.</p></div></div>
      </div>

      <!-- Mid-page WhatsApp CTA -->
      <div class="crs-cta-band">
        <div>
          <h2>Want the full syllabus and fee before you decide?</h2>
          <p>We'll send the module-by-module syllabus, batch dates and the exact fee with instalment options. No hidden costs.</p>
        </div>
        <a class="btn btn--primary btn--arrow" data-cta="cta2_whatsapp" target="_blank" rel="noopener noreferrer"
           href="https://wa.me/917736560333?text=Hi%20TechBound%2C%20please%20share%20the%20AI%20360%20SEO%20course%20syllabus%20and%20fee">
          Get Syllabus &amp; Fee on WhatsApp
        </a>
      </div>
    </div>
  </section>

  <!-- ===== 5a. AGENCY INTERNSHIP ===== -->
  <section class="crs-section crs-section--tint" id="internship" data-nav="light">
    <div class="crs-wrap crs-split">
      <div>
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Agency Internship
        </span>
        <h2 class="crs-title">Learn inside an agency, not just a classroom</h2>
        <p class="crs-lead" style="margin-bottom:20px;">
          TechBound has run <a href="<?= url('seo.php') ?>" style="color:var(--brand);text-decoration:underline;">SEO</a>, <a href="<?= url('ai-seo.php') ?>" style="color:var(--brand);text-decoration:underline;">AI SEO</a>, ads and websites for businesses since 2009, with clients across 6+ countries. When you join this course, you join that work. Your internship tasks come from real client accounts: clinics, builders, homestays, textile shops, study-abroad consultancies and online stores.
        </p>
        <h3 style="font-family:var(--font-heading);font-size:19px;font-weight:600;color:#0a1220;margin:0 0 14px;">What you'll do on live projects</h3>
        <ul class="crs-ticks">
          <li>Run a full technical SEO audit and present fixes</li>
          <li>Build a keyword map for a service business</li>
          <li>Optimise a Google Business Profile and track map-pack movement</li>
          <li>Write and publish AI-friendly content with FAQ schema</li>
          <li>Check how ChatGPT, Gemini and AI Overviews answer a client's key questions, then improve the brand's chances of being cited</li>
          <li>Prepare a monthly report in Looker Studio</li>
        </ul>
      </div>
      <div class="crs-split__media">
        <img src="<?= asset('assets/services/seo.jpg') ?>" alt="Student learning AI SEO, AEO and GEO at TechBound's SEO course in Kerala" loading="lazy">
      </div>
    </div>
  </section>

  <!-- ===== 5b. YOUR MENTOR (SHABNA NAZEER ONLY) ===== -->
  <section class="crs-section" id="mentor" data-nav="light">
    <div class="crs-wrap">
      <div class="crs-mentor">
        <div class="crs-mentor__photo">
          <img src="<?= asset('assets/team/shabna-nazeer.jpg') ?>" alt="Shabna Nazeer, Co-founder & Lead SEO Tutor at TechBound Digital Innovations" loading="lazy">
        </div>
        <div>
          <span class="pill pill--glow">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
            Your Tutor
          </span>
          <h2 class="crs-title" style="margin-top:14px;">Learn directly from Shabna Nazeer</h2>
          <p class="crs-lead" style="margin-bottom:14px;">
            <strong>Shabna Nazeer, Co-founder &amp; Lead Tutor</strong>: 15+ years leading SEO, AI search and digital growth campaigns at TechBound Digital Innovations across 250+ client projects in India and 6+ countries.
          </p>
          <p style="font-family:var(--font-body);font-size:15.5px;line-height:1.7;color:#4b5852;margin:0 0 18px;">
            Your tutor runs live SEO and GEO campaigns at TechBound every day, so what you learn in class on Monday is what is actually working for real clients this month.
          </p>
          <ul class="crs-ticks">
            <li>Career guidance and interview prep</li>
            <li>Weekly feedback on your own live project</li>
            <li>Doubt-clearing in English or Malayalam</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== 5c. FREE VS PAID ===== -->
  <section class="crs-section crs-section--soft" id="compare" data-nav="light">
    <div class="crs-wrap">
      <div class="crs-head">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          An Honest Comparison
        </span>
        <h2 class="crs-title">"Can't I learn this free on YouTube?"</h2>
        <p class="crs-lead">Yes, you can learn a lot of SEO free, and we'll recommend good free resources ourselves. What free videos can't give you is someone checking your work, a real website to practise on, and proof for an employer.</p>
      </div>

      <div class="crs-compare-wrap">
        <table class="crs-compare">
          <thead><tr><th></th><th>Free videos &amp; courses</th><th>AI 360 SEO at TechBound</th></tr></thead>
          <tbody>
            <tr><td>Theory and concepts</td><td>Yes</td><td>Yes</td></tr>
            <tr><td>AEO and GEO for AI search</td><td>Scattered, often outdated</td><td>Dedicated modules, updated with live client data</td></tr>
            <tr><td>Practice on a live client website</td><td class="crs-no">No</td><td>Yes, during the agency internship</td></tr>
            <tr><td>Feedback on your own work</td><td class="crs-no">No</td><td>Weekly tutor review</td></tr>
            <tr><td>Portfolio an employer can check</td><td>You build it alone</td><td>Built with you, project by project</td></tr>
            <tr><td>Doubts answered in Malayalam</td><td>Sometimes</td><td>Always</td></tr>
            <tr><td>Interview and freelance support</td><td class="crs-no">No</td><td>Yes</td></tr>
          </tbody>
        </table>
      </div>

      <div class="crs-callout">
        <strong>Run a business?</strong> If you only want to manage your own SEO, or check whether your agency is doing its job, ask about our short, one-to-one track.
      </div>
    </div>
  </section>

  <!-- ===== 5d. CAREER PATHS ===== -->
  <section class="crs-section crs-section--dark" data-nav="dark">
    <div class="crs-wrap">
      <span class="pill pill--glow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Career Paths
      </span>
      <h2 class="crs-title">What jobs can you get after an SEO course?</h2>
      <p class="crs-answer" style="margin-left:0;">
        After the AI 360 SEO course you can apply for roles such as SEO Executive, SEO Specialist, AI SEO Specialist, Content Strategist, Local SEO Specialist and Digital Marketing Executive, or work as a freelance SEO consultant. Your internship portfolio is what proves you can do the job.
      </p>

      <div class="crs-roles">
        <span class="crs-role-pill">SEO Executive</span>
        <span class="crs-role-pill">SEO Specialist</span>
        <span class="crs-role-pill crs-role-pill--accent">AI SEO / GEO Specialist</span>
        <span class="crs-role-pill">Technical SEO Analyst</span>
        <span class="crs-role-pill">Content Strategist</span>
        <span class="crs-role-pill">Local SEO Specialist</span>
        <span class="crs-role-pill">Digital Marketing Executive</span>
        <span class="crs-role-pill crs-role-pill--accent">Freelance SEO Consultant</span>
      </div>

      <p class="crs-answer" style="margin-left:0;margin-top:0;">
        <strong style="color:#fff;">Honest note:</strong> Freshers usually start at &#8377;15,000&ndash;&#8377;30,000 a month; India-wide averages for SEO executives sit around &#8377;2.7&ndash;4.4 lakh a year (AmbitionBox and Glassdoor). Pay grows with results you can show.
      </p>
    </div>
  </section>

  <!-- ===== 5e. WHO SHOULD JOIN ===== -->
  <section class="crs-section" data-nav="light">
    <div class="crs-wrap">
      <div class="crs-head">
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Who It's For
        </span>
        <h2 class="crs-title">Who is this SEO course for?</h2>
        <p class="crs-lead">No coding or marketing background needed. Basic computer use and curiosity are enough.</p>
      </div>

      <div class="crs-who-grid">
        <div class="crs-who-card">Plus-two pass-outs and graduates who want a practical career skill</div>
        <div class="crs-who-card">Working professionals switching into digital marketing</div>
        <div class="crs-who-card">Professionals returning after a career break</div>
        <div class="crs-who-card">Content writers and web developers adding SEO</div>
        <div class="crs-who-card">Business owners who want to understand and control their own SEO</div>
        <div class="crs-who-card">Freelancers who want AI search as a new service to sell</div>
      </div>
    </div>
  </section>

  <!-- ===== 6a. FAQ (Unified TechBound .faq) ===== -->
  <section class="faq" id="faq" data-nav="light">
    <div class="faq__inner">
      <h2 class="faq__title">Frequently Asked Questions</h2>
      <div class="faq__list">
        <?php
        $course_faqs = [
          ['Is SEO replaced by AI?', 'No. AI changed where people search, not whether businesses need to be found. AI Overviews, ChatGPT and Gemini build answers from websites, so brands still need SEO, plus AEO and GEO to be quoted in those answers. This course teaches all three.'],
          ['What is the difference between SEO, AEO and GEO?', 'SEO helps a website rank in search results. AEO (Answer Engine Optimization) helps it become the direct answer in featured snippets, People Also Ask and voice search. GEO (Generative Engine Optimization) helps a brand get mentioned and cited by AI assistants like ChatGPT, Gemini and Perplexity.'],
          ['Can I learn SEO in 3 months?', 'You can learn the core skills in about three months of regular practice. Becoming job-ready takes that plus hands-on work on real websites, which is why the course includes an agency internship.'],
          ['What is the fee for the AI 360 SEO course?', 'The course fee is shared with instalment options. It covers training, the agency internship, tools access and the certificate. Ask us on WhatsApp for the full fee breakdown.'],
          ['Can I join after plus-two?', 'Yes. You need basic computer skills and good reading in English. Classes include Malayalam explanations.'],
          ['Is the course online or offline?', 'Both. Join at our office or attend live online classes, with weekday and weekend batches. Recordings are available if you miss a session.'],
          ['Do you offer placement?', 'We offer placement support: portfolio building, mock interviews, CV help and referrals to hiring partners. We don\'t promise "100% placement"; we prepare you so your work speaks for you.'],
          ['Will I get a certificate?', 'Yes, a TechBound course and internship certificate. Your portfolio of real projects will matter more to employers than any certificate, so we help you build both.'],
          ['Which SEO tools will I learn?', 'Google Search Console, Google Analytics 4, Looker Studio, Screaming Frog, PageSpeed Insights, Ahrefs or Semrush, and AI tools such as ChatGPT and Gemini for research and content workflows.'],
          ['Can I freelance after this course?', 'Yes. SEO is one of the easiest digital skills to freelance. The course covers pricing, proposals and client handling, and your internship projects become your first case studies.'],
          ['I run a business. Is there a shorter option?', 'Ask us about the one-to-one track for business owners who want to manage their own SEO or check an agency\'s work.'],
        ];
        foreach ($course_faqs as $idx => [$q, $a]):
          $isOpen = $idx === 0;
        ?>
        <div class="faq__item<?= $isOpen ? ' is-open' : '' ?>">
          <h3>
            <button class="faq__question" type="button" aria-expanded="<?= $isOpen ? 'true' : 'false' ?>" aria-controls="cfaq-<?= $idx + 1 ?>">
              <?= ($idx + 1) . '. ' . htmlspecialchars($q) ?>
            </button>
          </h3>
          <div class="faq__answer" id="cfaq-<?= $idx + 1 ?>">
            <div class="faq__answer-inner">
              <p><?= $a ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== 6b + 6c. FINAL CTA + ENQUIRY FORM ===== -->
  <section class="crs-section crs-section--tint" id="enquire" data-nav="light">
    <div class="crs-wrap crs-enquire-grid">
      <div>
        <span class="pill pill--glow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
          Your Next Step
        </span>
        <h2 class="crs-title">Learn today. <em>Lead tomorrow.</em></h2>
        <p class="crs-lead" style="margin-bottom:24px;">
          Not sure if SEO is right for you? Talk to our course team for 15 minutes. We'll look at your background and tell you honestly whether this course fits, even if the answer is no.
        </p>
        <a href="tel:+917736560333" class="btn btn--primary btn--arrow" data-cta="cta3_call">Talk to a Career Mentor</a>
        <p style="margin-top:14px;font-size:14.5px;color:#4b5852;">Or fill the form and we'll call you back within one working day.</p>
        <p style="margin-top:26px;font-size:15px;line-height:1.7;color:#1f2e27;">
          <strong>TechBound Digital Innovations</strong><br>
          6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram 695001<br>
          <a href="tel:+917736560333" style="color:var(--brand);">+91 77365 60333</a> &middot; <a href="mailto:office@techbound.in" style="color:var(--brand);">office@techbound.in</a>
        </p>
      </div>

      <div class="crs-form-card">
        <form id="courseLeadForm" class="tb-call-form" method="post" action="<?= url('send-contact.php') ?>">
          <h3>Book your seat in the next AI 360 SEO batch</h3>
          <p class="crs-form-card__sub">Seats are limited so every learner gets tutor time.</p>

          <div class="tb-call-form__row">
            <div class="tb-call-field">
              <label for="crs-name">Full name *</label>
              <input type="text" id="crs-name" name="name" required placeholder="Your name" autocomplete="name">
            </div>
            <div class="tb-call-field">
              <label for="crs-phone">Mobile (WhatsApp) *</label>
              <input type="tel" id="crs-phone" name="phone" required placeholder="+91 98XXX XXXXX" autocomplete="tel">
            </div>
          </div>

          <div class="tb-call-field">
            <label for="crs-email">Email *</label>
            <input type="email" id="crs-email" name="email" required placeholder="you@example.com" autocomplete="email">
          </div>

          <div class="tb-call-form__row">
            <div class="tb-call-field">
              <label for="crs-persona">I am a&hellip; *</label>
              <select id="crs-persona" name="persona" required>
                <option value="">Select one</option>
                <option value="Student / Plus-two pass-out">Student / Plus-two pass-out</option>
                <option value="Graduate">Graduate</option>
                <option value="Working professional">Working professional</option>
                <option value="Returning after a break">Returning after a break</option>
                <option value="Business owner">Business owner</option>
                <option value="Freelancer">Freelancer</option>
              </select>
            </div>
            <div class="tb-call-field">
              <label for="crs-goal">What do you want from this course?</label>
              <select id="crs-goal" name="goal">
                <option value="">Select one</option>
                <option value="Get a job">Get a job</option>
                <option value="Switch career">Switch career</option>
                <option value="Freelance">Freelance</option>
                <option value="Grow my own business">Grow my own business</option>
              </select>
            </div>
          </div>

          <div class="tb-call-form__row">
            <div class="tb-call-field">
              <label>Preferred mode *</label>
              <div class="crs-radios">
                <label><input type="radio" name="mode" value="Offline" checked><span>Offline</span></label>
                <label><input type="radio" name="mode" value="Online"><span>Online</span></label>
              </div>
            </div>
            <div class="tb-call-field">
              <label>Preferred batch *</label>
              <div class="crs-radios">
                <label><input type="radio" name="batch" value="Weekday" checked><span>Weekday</span></label>
                <label><input type="radio" name="batch" value="Weekend"><span>Weekend</span></label>
              </div>
            </div>
          </div>

          <div class="tb-call-field">
            <label for="crs-msg">Your question</label>
            <textarea id="crs-msg" name="question_text" rows="3" placeholder="Anything you'd like us to know"></textarea>
          </div>

          <label class="crs-consent">
            <input type="checkbox" id="crs-consent" required>
            <span>I agree to be contacted by TechBound on phone and WhatsApp about this course. *</span>
          </label>

          <!-- Hidden mapped fields for send-contact.php + honeypot + reCAPTCHA v3 -->
          <input type="hidden" name="service" value="AI 360 SEO Course">
          <input type="hidden" name="company" id="crs-hidden-company" value="AI 360 SEO Course Enquiry">
          <input type="hidden" name="message" id="crs-hidden-message" value="">
          <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
            <input type="text" name="fax_number" tabindex="-1" autocomplete="off">
          </div>
          <input type="hidden" name="_form_ts" value="<?= time() ?>">
          <input type="hidden" name="recaptcha_token" id="crs-recaptcha-token" value="">

          <button type="submit" class="btn btn--primary btn--sm btn--arrow" style="width:100%;justify-content:center;">Book My Seat</button>
          <p style="text-align:center;font-size:13px;color:#5b6962;margin:6px 0 0;">No spam. We'll only contact you about this course.</p>
          <p id="courseLeadStatus" class="tb-call-form__status" role="status" aria-live="polite"></p>
        </form>
      </div>
    </div>
  </section>

</main>

<script>
(function () {
  // Persona tabs
  document.querySelectorAll('.crs-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
      document.querySelectorAll('.crs-tab').forEach(function (t) { t.setAttribute('aria-selected', 'false'); });
      document.querySelectorAll('.crs-panel').forEach(function (p) { p.classList.remove('is-active'); });
      tab.setAttribute('aria-selected', 'true');
      var target = document.getElementById(tab.getAttribute('aria-controls'));
      if (target) target.classList.add('is-active');
    });
  });

  // Curriculum accordion
  document.querySelectorAll('.crs-acc__btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var item = btn.parentElement;
      var body = item.querySelector('.crs-acc__body');
      var open = item.classList.toggle('is-open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      if (body) body.style.maxHeight = open ? body.scrollHeight + 'px' : '0px';
    });
  });

  // Course enquiry form AJAX submit
  var form = document.getElementById('courseLeadForm');
  var statusEl = document.getElementById('courseLeadStatus');
  if (form && statusEl) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var nameVal    = (document.getElementById('crs-name').value || '').trim();
      var phoneVal   = (document.getElementById('crs-phone').value || '').trim();
      var personaVal = (document.getElementById('crs-persona').value || '').trim();
      var goalVal    = (document.getElementById('crs-goal').value || '').trim();
      var modeEl     = form.querySelector('input[name="mode"]:checked');
      var batchEl    = form.querySelector('input[name="batch"]:checked');
      var qVal       = (document.getElementById('crs-msg').value || '').trim();

      var modeVal  = modeEl ? modeEl.value : 'Offline';
      var batchVal = batchEl ? batchEl.value : 'Weekday';

      document.getElementById('crs-hidden-company').value = 'AI 360 SEO Course (' + modeVal + ' / ' + batchVal + ')';
      document.getElementById('crs-hidden-message').value =
        'Course: AI 360 SEO Course\n' +
        'Profile: ' + (personaVal || '-') + '\n' +
        'Goal: ' + (goalVal || '-') + '\n' +
        'Preferred Mode: ' + modeVal + '\n' +
        'Preferred Batch: ' + batchVal + '\n' +
        'WhatsApp / Mobile: ' + phoneVal + '\n' +
        (qVal ? 'Question: ' + qVal : 'Requested demo / seat booking.');

      var btn = form.querySelector('button[type="submit"]');
      if (btn) btn.disabled = true;
      statusEl.className = 'tb-call-form__status';
      statusEl.textContent = 'Submitting your seat request...';

      var getToken = (typeof window.tbGetRecaptchaToken === 'function')
        ? window.tbGetRecaptchaToken('course_lead')
        : Promise.resolve('');

      getToken.then(function (token) {
        var tok = document.getElementById('crs-recaptcha-token');
        if (tok) tok.value = token || '';
        return fetch(form.getAttribute('action'), { method: 'POST', body: new FormData(form) });
      })
        .then(function (r) { return r.json().catch(function () { return { ok: false, message: 'Unexpected server response.' }; }); })
        .then(function (data) {
          if (!data || !data.ok) throw new Error((data && data.message) || 'Could not submit right now. Please call +91 77365 60333.');
          if (window.gtag) gtag('event', 'generate_lead', { persona: personaVal, mode: modeVal });
          form.reset();
          statusEl.className = 'tb-call-form__status is-ok';
          statusEl.textContent = 'Thanks, ' + (nameVal.split(' ')[0] || 'there') + '! Your AI 360 SEO seat request has been received. A TechBound mentor will call you within one working day.';
        })
        .catch(function (err) {
          statusEl.className = 'tb-call-form__status is-err';
          statusEl.textContent = (err && err.message) ? err.message : 'Could not send right now. Please call +91 77365 60333.';
        })
        .finally(function () {
          if (btn) btn.disabled = false;
        });
    });
  }
})();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
