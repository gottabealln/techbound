<?php
/**
 * Shared Context-Aware Audit / Quick-Enquiry Popup Modal
 * Triggered by any link/button with data-audit-modal="<preset>"
 */
?>
<!-- ===== SMART CONTEXT-AWARE AUDIT / ENQUIRY MODAL ===== -->
<div class="tb-call-modal tb-audit-modal" id="tbAuditModal" role="dialog" aria-modal="true" aria-labelledby="tbAuditModalTitle" hidden>
  <div class="tb-call-modal__backdrop" data-close-audit-modal></div>
  <div class="tb-call-modal__dialog tb-audit-modal__dialog">
    <button type="button" class="tb-call-modal__close" data-close-audit-modal aria-label="Close popup">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
    </button>

    <div class="tb-audit-modal__body">
      <span class="pill pill--glow" id="tbAuditBadge">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        <span id="tbAuditBadgeText">Free Audit</span>
      </span>

      <h2 id="tbAuditModalTitle" class="tb-audit-modal__title">Get Your Free Audit</h2>
      <p id="tbAuditModalLead" class="tb-audit-modal__lead">Share your details below and our team will get back to you within one working day.</p>

      <form id="tbAuditModalForm" class="tb-call-form" method="post" action="<?= url('send-contact.php') ?>">
        <div class="tb-call-field" data-audit-field="name" hidden>
          <label for="tba-name">Your Name *</label>
          <input type="text" id="tba-name" name="visible_name" placeholder="Full name" autocomplete="name">
        </div>

        <div class="tb-call-field" data-audit-field="phone">
          <label for="tba-phone">Your Contact Number *</label>
          <input type="tel" id="tba-phone" name="phone" required placeholder="+91 98765 43210" autocomplete="tel">
        </div>

        <div class="tb-call-field" data-audit-field="email">
          <label for="tba-email">Email ID *</label>
          <input type="email" id="tba-email" name="email" required placeholder="you@company.com" autocomplete="email">
        </div>

        <div class="tb-call-field" data-audit-field="site_url">
          <label for="tba-url" id="tba-url-label">Website URL *</label>
          <input type="text" id="tba-url" name="site_url" placeholder="https://yourwebsite.com" autocomplete="url">
        </div>

        <div class="tb-call-field" data-audit-field="budget" hidden>
          <label for="tba-budget">Monthly Ad Budget</label>
          <select id="tba-budget" name="ad_budget">
            <option value="">Select budget range (optional)</option>
            <option value="Under ₹50,000 / month">Under ₹50,000 / month</option>
            <option value="₹50,000 – ₹2,00,000 / month">₹50,000 – ₹2,00,000 / month</option>
            <option value="₹2,00,000 – ₹5,00,000 / month">₹2,00,000 – ₹5,00,000 / month</option>
            <option value="₹5,00,000+ / month">₹5,00,000+ / month</option>
          </select>
        </div>

        <!-- Hidden fields mapped cleanly for send-contact.php -->
        <input type="hidden" name="name" id="tba-hidden-name" value="">
        <input type="hidden" name="company" id="tba-hidden-company" value="">
        <input type="hidden" name="service" id="tba-hidden-service" value="Free SEO Audit">
        <input type="hidden" name="message" id="tba-hidden-message" value="">

        <!-- Honeypot + timing + reCAPTCHA v3 -->
        <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
          <input type="text" name="website" tabindex="-1" autocomplete="off">
          <input type="text" name="fax_number" tabindex="-1" autocomplete="off">
        </div>
        <input type="hidden" name="_form_ts" id="tba-ts" value="<?= time() ?>">
        <input type="hidden" name="recaptcha_token" id="tba-recaptcha-token" value="">

        <button type="submit" id="tbAuditSubmitBtn" class="btn btn--primary btn--sm btn--arrow tb-audit-form__submit">Request Free Audit</button>
        <p id="tbAuditModalStatus" class="tb-call-form__status" role="status" aria-live="polite"></p>
      </form>
    </div>
  </div>
</div>

<!-- ===== BACK TO TOP BUTTON ===== -->
<button type="button" id="tbBackToTop" class="tb-back-to-top" aria-label="Back to top" title="Back to top">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="M12 19V5"/>
    <path d="m5 12 7-7 7 7"/>
  </svg>
</button>
