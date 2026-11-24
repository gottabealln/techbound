<?php
$req_service  = trim($_GET['service'] ?? '');
$page_title   = 'Contact Us | TechBound Digital Marketing Agency in Trivandrum';
$page_desc    = 'Get in touch with TechBound in Trivandrum, Kerala. Schedule a consultation for SEO, digital marketing, website development, or PPC advertising solutions.';
$page_styles = ['css/contact.css'];
$page_slug   = 'contact';
$page_scripts = [
    'js/pages/contact/contact-form.js'
];

require __DIR__ . '/includes/header.php';
?>
<main>

  <!-- ===== HERO ===== -->
  <section class="hero hero--inner" style="background-image: url('<?= asset('assets/contact_us.jpg') ?>');">
    <div class="hero__overlay"></div>

    <div class="hero__content">
      <div class="hero__tagline-wrap">
        <nav class="hero__crumbs" aria-label="Breadcrumb">
          <a href="<?= url('index.php') ?>">Home</a><span>/</span>
          <span class="is-current">Contact Us</span>
        </nav>
        <div class="hero__line"></div>
      </div>

      <div class="hero__body">
        <div class="hero__text">
          <h1 class="hero__title">Let's Talk About Your Growth</h1>
          <p class="hero__desc">
            Tell us about your business, challenges and goals. Our team in Trivandrum will get back to you within one working day with actionable ideas.
          </p>
        </div>

        <div class="hero__buttons">
          <a href="#contact-form" class="btn btn--primary btn--arrow">Send a Message</a>
          <a href="tel:+918606497677" class="btn btn--outline btn--arrow">Call Directly</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section class="contact" data-nav="light">
    <div class="contact__inner">

      
      <div class="contact__info">
        <span class="pill pill--glow" data-animate>
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Get in Touch
      </span>
        <h2 class="contact__title" data-animate style="--d:80ms">Let's Talk About Your Growth</h2>
        <p class="contact__lead" data-animate style="--d:160ms">
          Tell us about your business and goals. Our team in Trivandrum will get back to you
          within one working day with ideas and a clear plan.
        </p>

        <ul class="contact__list">
          <li data-animate style="--d:240ms">
            <a href="tel:+91 8606497677">
              <span class="contact__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
              </span>
              <span class="contact__text"><small>Call us</small>+91 8606497677</span>
            </a>
          </li>
          <li data-animate style="--d:320ms">
            <a href="mailto:contacts@techbound.in">
              <span class="contact__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
              </span>
              <span class="contact__text"><small>Email us</small>contacts@techbound.in</span>
            </a>
          </li>
          <?php
$map_link = 'https://www.google.com/maps/search/?api=1&query=' . urlencode('TechBound Digital Marketing Agency Trivandrum, 6th Floor, Karimpanal Statue Avenue, Thiruvananthapuram 695001');
?>
<li data-animate style="--d:400ms">
  <a href="<?= $map_link ?>" target="_blank" rel="noopener" aria-label="Open Techbound location in Google Maps">
    <span class="contact__icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
    </span>
    <span class="contact__text"><small>Visit us</small>6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, 695001</span>
  </a>
</li>
          <li data-animate style="--d:480ms">
            <div class="contact__row">
              <span class="contact__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
              </span>
              <span class="contact__text"><small>Working hours</small>Mon – Sat, 9:00 AM – 6:30 PM</span>
            </div>
          </li>
        </ul>
      </div>

      <!-- Right: form -->
      <div class="contact__form-wrap" data-animate style="--d:120ms">
        <h2 class="contact__form-title">Send us a message</h2>

        <form class="cform" id="contactForm" action="<?= url('send-contact.php') ?>" method="post" novalidate>

          <div class="field">
            <input type="text" id="cf-name" name="name" placeholder=" " autocomplete="name" required>
            <label for="cf-name">Full Name</label>
            <span class="field__error"></span>
          </div>

          <div class="field">
            <input type="email" id="cf-email" name="email" placeholder=" " autocomplete="email" required>
            <label for="cf-email">Email Address</label>
            <span class="field__error"></span>
          </div>

          <div class="cform__phone">
            <div class="field field--code">
              <input type="text" id="cf-code" name="code" value="+91" aria-label="Country code">
            </div>
            <div class="field">
              <input type="tel" id="cf-phone" name="phone" placeholder=" " autocomplete="tel-national">
              <label for="cf-phone">Phone Number</label>
              <span class="field__error"></span>
            </div>
          </div>

          <div class="field">
            <select id="cf-service" name="service">
              <option value="" <?= empty($req_service) ? 'selected' : '' ?>>Select Service / Inquiry Type</option>
              <option value="Website Development" <?= stripos($req_service, 'Web') !== false ? 'selected' : '' ?>>Website Development</option>
              <option value="Lead Generation" <?= stripos($req_service, 'Lead') !== false ? 'selected' : '' ?>>Lead Generation</option>
              <option value="Real Estate Marketing" <?= (stripos($req_service, 'Real Estate') !== false || stripos($req_service, 'Construct') !== false) ? 'selected' : '' ?>>Real Estate Marketing</option>
              <option value="SEO" <?= (stripos($req_service, 'SEO') !== false && stripos($req_service, 'AI') === false) ? 'selected' : '' ?>>Search Engine Optimization (SEO)</option>
              <option value="AI SEO" <?= stripos($req_service, 'AI') !== false ? 'selected' : '' ?>>AI SEO &amp; Generative Search</option>
              <option value="Online Advertising" <?= (stripos($req_service, 'Ad') !== false || stripos($req_service, 'PPC') !== false) ? 'selected' : '' ?>>Paid Online Advertising (Google &amp; Meta)</option>
              <option value="SMM" <?= (stripos($req_service, 'SMM') !== false || stripos($req_service, 'Social') !== false) ? 'selected' : '' ?>>Social Media Marketing (SMM)</option>
              <option value="General Consultation" <?= $req_service === 'General Consultation' ? 'selected' : '' ?>>General Growth Consultation</option>
            </select>
            <label for="cf-service">Service of Interest</label>
          </div>

          <div class="field">
            <input type="text" id="cf-company" name="company" placeholder=" " autocomplete="organization">
            <label for="cf-company">Company Name</label>
          </div>

          <div class="field">
            <textarea id="cf-message" name="message" rows="3" placeholder=" " required></textarea>
            <label for="cf-message">Tell us about your project</label>
            <span class="field__error"></span>
          </div>

        
          <div class="cform__trap" aria-hidden="true">
            <input type="text" name="website" tabindex="-1" autocomplete="off">
            <input type="text" name="fax_number" tabindex="-1" autocomplete="off">
          </div>
          <input type="hidden" name="_form_ts" value="<?= time() ?>">
          <input type="hidden" name="recaptcha_token" id="cf-recaptcha-token" value="">

          <p class="cform__note">
            By sending this form I confirm that I have read and accept Techbound's
            <a href="<?= url('privacy-policy.php') ?>">privacy policy</a>.
          </p>

          <button type="submit" class="btn btn--primary btn--sm btn--arrow cform__submit">Send Message</button>

          <p class="cform__status" id="cformStatus" role="status" aria-live="polite"></p>
        </form>
      </div>

    </div>
  </section>


<?php
$map_address = '6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, 695001';
$map_q       = urlencode('Techbound, ' . $map_address);
?>
<section class="map-section">
  <div class="container">
    <div class="map-wrap">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.0128912179903!2d76.94543917501265!3d8.498126591543524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05ba2d0ad3aab9%3A0xf24e9cee61cb2a41!2sTechBound%20Digital%20Marketing%20Agency%20Trivandrum!5e0!3m2!1sen!2sin!4v1792383022840!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"
        title="Techbound location"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen></iframe>

     
    </div>
  </div>
</section>

<?php
$faq_page  = 'contact';
$faq_title = 'Frequently Asked Questions';
require __DIR__ . '/includes/faq-section.php';
?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>