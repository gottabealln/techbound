<?php

require_once __DIR__ . '/../config/site.php';
$page_scripts = $page_scripts ?? [];
?>

   <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <!-- call to action band with background image + gradient -->
    <div class="footer__cta-band">
      <div class="footer__inner">
        <div class="footer__cta">
          <div class="footer__cta-text">
            <h2 class="footer__title">Get Started Now</h2>
            <p class="footer__lead">
              If you would like to work with us or just want to get in touch, we'd love to hear from you!
            </p>
          </div>
          <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow">Contact Us</a>
        </div>
      </div>
    </div>

    <div class="footer__body">
      <div class="footer__inner">

      <!-- columns -->
      <div class="footer__grid">
        <div class="footer__col">
          <a href="<?= url('index.php') ?>" class="footer__logo">
            <img src="<?= url('assets/logo_techbound.png') ?>" alt="TechBound logo">
          </a>
          
          <address class="footer__address">
             Fl -2,<br>
             Thejaswini, SBC 7, Technopark Campus<br>
            Phase I, Thiruvananthapuram, Keralam 695581
          </address>

          <div class="footer__social">
            <a href="https://www.facebook.com/techboundDigitalAgency" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
            <a href="http://instagram.com/techboundinnovations/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.351-.2 6.78-2.618 6.98-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
            <a href="https://www.linkedin.com/company/techboundinnovations" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
            <a href="https://x.com/techbounddgtl" target="_blank" rel="noopener noreferrer" aria-label="X"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg></a>
            <a href="https://www.threads.com/@techboundinnovations" target="_blank" rel="noopener noreferrer" aria-label="Threads"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.186 24c-3.606 0-6.529-1.182-8.457-3.419C1.8 18.344 1 15.316 1 11.83 1 8.344 1.848 5.334 3.748 3.107 5.65.88 8.653 0 12.247 0c3.545 0 6.452.898 8.406 2.597 1.954 1.7 2.947 4.256 2.947 7.595 0 2.21-.497 4.14-1.49 5.792-.994 1.652-2.392 2.87-4.195 3.655-1.803.785-3.924 1.177-6.363 1.177-.662 0-1.32-.03-1.974-.09-.044.403-.066.81-.066 1.22 0 1.874.57 3.327 1.71 4.36 1.14 1.033 2.68 1.55 4.62 1.55 1.547 0 2.973-.34 4.278-1.02v2.38c-1.393.593-2.92.89-4.58.89l-.348-.106zM13.2 7.71c-1.19 0-2.18.396-2.97 1.188-.79.792-1.185 1.782-1.185 2.97 0 1.188.395 2.178 1.185 2.97.79.792 1.78 1.188 2.97 1.188 1.188 0 2.178-.396 2.97-1.188.792-.792 1.188-1.782 1.188-2.97 0-1.188-.396-2.178-1.188-2.97-.792-.792-1.782-1.188-2.97-1.188z"/></svg></a>
            <a href="https://www.youtube.com/@techboundinnovations1257" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
          </div>
        </div>

        <div class="footer__col">
          <h3 class="footer__heading">Company</h3>
          <ul class="footer__list">
            <li><a href="<?= url('index.php') ?>">Home</a></li>
            <li><a href="<?= url('about.php') ?>">About</a></li>
            <li><a href="<?= url('services.php') ?>">Our Services</a></li>
            <?php /* <li><a href="<?= url('portfolio.php') ?>">Portfolio</a></li> */ ?>
            <li><a href="<?= url('blog.php') ?>">Blog</a></li>
            <li><a href="<?= url('careers.php') ?>">Careers</a></li>
            <li><a href="<?= url('contact.php') ?>">Contact</a></li>
          </ul>
        </div>

        <div class="footer__col">
          <h3 class="footer__heading">Services</h3>
          <ul class="footer__list">
            <li><a href="<?= url('seo.php') ?>">Search Engine Optimization</a></li>
            <li><a href="<?= url('ai-seo.php') ?>">AI SEO &amp; Search</a></li>
            <li><a href="<?= url('online-advertising.php') ?>">Online Advertising</a></li>
            <li><a href="<?= url('smm.php') ?>">Social Media Marketing</a></li>
            <li><a href="<?= url('website-development.php') ?>">Website Development</a></li>
            <li><a href="<?= url('lead-generation.php') ?>">Lead Generation</a></li>
            <li><a href="<?= url('construction.php') ?>">Real Estate Marketing</a></li>
          </ul>
        </div>

        <div class="footer__col">
          <h3 class="footer__heading">Contact</h3>
          <ul class="footer__list footer__list--contact">
            <li><span>Call</span><a href="tel:+918606497677">+91 8606497677</a></li>
            <li><span>Email</span><a href="mailto:office@techbound.in">office@techbound.in</a></li>
            <li><span>Hours</span>Mon to Fri: 9.00 am - 6.30 pm</li>
          </ul>
        </div>
      </div>

      <!-- bottom bar -->
      <div class="footer__bottom">
        <p>© 2026 All rights reserved by TechBound</p>
        <div class="footer__legal">
          <a href="<?= url('privacy-policy.php') ?>">Privacy Policy</a>
          <a href="<?= url('privacy-policy.php') ?>">Terms and Conditions</a>
        </div>
      </div>
      </div>
    </div>

    
  </footer>

  <!-- ===== BOOK A CALL / CONTACT POPUP MODAL ===== -->
  <div class="tb-call-modal" id="tbCallModal" role="dialog" aria-modal="true" aria-labelledby="tbCallModalTitle" hidden>
    <div class="tb-call-modal__backdrop" data-close-call-modal></div>
    <div class="tb-call-modal__dialog">
      <button type="button" class="tb-call-modal__close" data-close-call-modal aria-label="Close contact menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
      </button>

      <div class="tb-call-modal__grid">
        <!-- Left: Direct Contact Details -->
        <div class="tb-call-modal__info">
          <span class="pill pill--glow">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
            Book a Call
          </span>
          <h2 id="tbCallModalTitle" class="tb-call-modal__title">Let's Talk About Your Growth</h2>
          <p class="tb-call-modal__lead">Reach our Trivandrum team directly or request a quick callback within one working day.</p>

          <ul class="tb-call-modal__details">
            <li>
              <a href="tel:+918606497677">
                <span class="tb-call-modal__icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg>
                </span>
                <span><small>Call Us</small><strong>+91 86064 97677</strong></span>
              </a>
            </li>
            <li>
              <a href="https://wa.me/918606497677" target="_blank" rel="noopener noreferrer">
                <span class="tb-call-modal__icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </span>
                <span><small>WhatsApp</small><strong>Chat on WhatsApp</strong></span>
              </a>
            </li>
            <li>
              <a href="mailto:contacts@techbound.in">
                <span class="tb-call-modal__icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/></svg>
                </span>
                <span><small>Email</small><strong>contacts@techbound.in</strong></span>
              </a>
            </li>
            <li>
              <div class="tb-call-modal__row">
                <span class="tb-call-modal__icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </span>
                <span>
                  <small>Offices</small>
                  <strong>Statue, Thiruvananthapuram &bull; Technopark Campus</strong>
                </span>
              </div>
            </li>
            <li>
              <div class="tb-call-modal__row">
                <span class="tb-call-modal__icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </span>
                <span><small>Hours</small><strong>Mon – Sat, 9:00 AM – 6:30 PM</strong></span>
              </div>
            </li>
          </ul>
        </div>

        <!-- Right: Quick Callback Form -->
        <div class="tb-call-modal__form-wrap">
          <h3 class="tb-call-modal__form-title">Request a Callback</h3>
          <form id="tbCallModalForm" class="tb-call-form" method="post" action="<?= url('send-contact.php') ?>">
            <div class="tb-call-field">
              <label for="tbc-name">Your Name *</label>
              <input type="text" id="tbc-name" name="name" required placeholder="Full name">
            </div>
            <div class="tb-call-form__row">
              <div class="tb-call-field">
                <label for="tbc-email">Email *</label>
                <input type="email" id="tbc-email" name="email" required placeholder="you@company.com">
              </div>
              <div class="tb-call-field">
                <label for="tbc-phone">Phone / WhatsApp *</label>
                <input type="tel" id="tbc-phone" name="phone" required placeholder="+91 98765 43210">
              </div>
            </div>
            <div class="tb-call-field">
              <label for="tbc-service">Service Needed</label>
              <select id="tbc-service" name="service">
                <option value="Book a Call">General Growth Consultation</option>
                <option value="SEO">Search Engine Optimization (SEO)</option>
                <option value="AI SEO">AI SEO &amp; Generative Search</option>
                <option value="Online Advertising">Online Advertising (Google &amp; Meta)</option>
                <option value="SMM">Social Media Marketing</option>
                <option value="Website Development">Website Development</option>
                <option value="Lead Generation">Lead Generation</option>
                <option value="Real Estate Marketing">Real Estate Marketing</option>
              </select>
            </div>
            <div class="tb-call-field">
              <label for="tbc-message">How can we help? *</label>
              <textarea id="tbc-message" name="message" rows="3" required placeholder="Briefly tell us about your business and goals..."></textarea>
            </div>

            <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
              <input type="text" name="website" tabindex="-1" autocomplete="off">
              <input type="text" name="fax_number" tabindex="-1" autocomplete="off">
            </div>
            <input type="hidden" name="_form_ts" id="tbc-ts" value="<?= time() ?>">
            <input type="hidden" name="recaptcha_token" id="tbc-recaptcha-token" value="">

            <button type="submit" class="btn btn--primary btn--sm btn--arrow tb-call-form__submit">Request Callback</button>
            <p id="tbCallModalStatus" class="tb-call-form__status" role="status" aria-live="polite"></p>
          </form>
        </div>
      </div>
    </div>
  </div>


  
  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="<?= asset('js/common/main.js') ?>"></script>

  <!-- scripts only some pages need (set in the page with $page_scripts) -->
  <?php foreach ($page_scripts as $script):
    if (strpos($script, 'main.js') !== false || strpos($script, 'reveal.js') !== false) continue;
  ?>
  <script src="<?= asset($script) ?>"></script>
  <?php endforeach; ?>

  <script src="<?= asset('js/common/reveal.js') ?>"></script>
</body>
</html>