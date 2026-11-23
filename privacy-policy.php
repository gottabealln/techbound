<?php
$page_title   = 'Privacy Policy | TechBound Innovations';
$page_desc    = 'Read the Privacy Policy of TechBound Innovations. Learn how we collect, use, and protect your personal data when using our website and digital services.';
$page_styles  = ['css/legal.css'];

require __DIR__ . '/includes/header.php';
?>

<main>
  <!-- ===== HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/services.avif') ?>');">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">Privacy Policy</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Privacy Policy</h1>
          <p class="hero__desc">
            How TechBound Innovations collects, uses, and safeguards your personal data when interacting with our website and digital services.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="legal" data-nav="light">
    <div class="legal__inner">
      <!-- Table of Contents -->
      <aside class="legal__toc">
        <h3 class="legal__toc-title">Contents</h3>
        <ol>
          <li><a href="#information-we-collect">Information We Collect</a></li>
          <li><a href="#how-we-use">How We Use Your Data</a></li>
          <li><a href="#cookies">Cookies &amp; Tracking</a></li>
          <li><a href="#data-sharing">Sharing &amp; Disclosure</a></li>
          <li><a href="#data-security">Data Security</a></li>
          <li><a href="#your-rights">Your Rights</a></li>
          <li><a href="#contact-us">Contact Information</a></li>
        </ol>
      </aside>

      <!-- Legal Body Content -->
      <article class="legal__body">
        <p class="legal__updated">Last Updated: November 2026</p>
        <p class="legal__intro">
          At TechBound Innovations ("TechBound", "we", "us", or "our"), we respect your privacy and are committed to protecting the personal data you share with us. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or engage our digital marketing and web services.
        </p>

        <h2 id="information-we-collect">1. Information We Collect</h2>
        <p>We may collect information about you in various ways when you interact with our website, including:</p>
        <ul>
          <li><strong>Contact Details:</strong> Your name, email address, phone number, and company name when you fill out consultation forms, contact forms, or job applications.</li>
          <li><strong>Service Inquiry Details:</strong> Information regarding your project requirements, budget, timeline, and current marketing channels.</li>
          <li><strong>Technical Data:</strong> Browser type, operating system, IP address, referral sources, and pages viewed, gathered automatically via server logs and analytics tools.</li>
        </ul>

        <h2 id="how-we-use">2. How We Use Your Data</h2>
        <p>The information we collect is used to deliver, maintain, and optimize our services, including:</p>
        <ul>
          <li>Responding promptly to your inquiries and providing proposals or quotes.</li>
          <li>Delivering customized digital marketing, SEO, advertising, and web development solutions.</li>
          <li>Evaluating job applicants for career openings.</li>
          <li>Analyzing website traffic and usage trends to enhance user experience and performance.</li>
          <li>Complying with legal obligations and protecting against fraudulent activity.</li>
        </ul>

        <h2 id="cookies">3. Cookies &amp; Tracking Technologies</h2>
        <p>
          We use cookies and similar tracking technologies to monitor activity on our website and hold certain information. Cookies help us analyze web traffic, remember your preferences, and serve targeted performance marketing campaigns. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.
        </p>

        <h2 id="data-sharing">4. Sharing &amp; Disclosure</h2>
        <p>
          We do not sell, trade, or rent your personal information to third parties. We may share information with trusted third-party service providers (such as hosting providers, CRM tools, or analytics partners) who assist us in operating our website and delivering our services, under strict confidentiality agreements.
        </p>

        <h2 id="data-security">5. Data Security</h2>
        <p>
          We employ industry-standard technical and organizational security measures to protect your personal information against unauthorized access, loss, misuse, or alteration. However, no electronic transmission over the internet or information storage technology can be guaranteed 100% secure.
        </p>

        <h2 id="your-rights">6. Your Rights</h2>
        <p>
          Depending on applicable privacy laws, you may have the right to request access to the personal data we hold about you, request corrections to inaccurate data, or request the erasure of your personal information.
        </p>

        <h2 id="contact-us">7. Contact Information</h2>
        <p>
          If you have questions or concerns regarding this Privacy Policy or our data handling practices, please contact us at:
        </p>
        <p>
          <strong>TechBound Innovations</strong><br>
          Email: <a href="mailto:contacts@techbound.in">contacts@techbound.in</a><br>
          Phone: <a href="tel:+918606497677">+91 86064 97677</a><br>
          Address: 6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, Kerala 695001
        </p>
      </article>
    </div>
  </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
