/**
 * TechBound Careers Page Interactive Controller
 * Handles department filtering, expandable job descriptions, auto-role selection,
 * file upload preview, and asynchronous AJAX application submission.
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // 1. Department Filtering
  const filterBtns = document.querySelectorAll('.cr-filter-btn');
  const jobCards = document.querySelectorAll('.cr-job-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');

      const filter = btn.getAttribute('data-filter') || 'all';

      jobCards.forEach(card => {
        const dept = card.getAttribute('data-dept') || '';
        if (filter === 'all' || dept === filter) {
          card.style.display = 'block';
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 20);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(6px)';
          setTimeout(() => {
            card.style.display = 'none';
          }, 180);
        }
      });
    });
  });

  // 2. Expandable Job Drawers
  const toggleDetailBtns = document.querySelectorAll('.js-toggle-details');
  toggleDetailBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const card = btn.closest('.cr-job-card');
      if (!card) return;

      const isExpanded = card.classList.contains('is-expanded');
      if (isExpanded) {
        card.classList.remove('is-expanded');
        btn.textContent = 'View Details';
      } else {
        card.classList.add('is-expanded');
        btn.textContent = 'Hide Details';
      }
    });
  });

  // 3. Quick Apply Trigger (Populates role dropdown and scrolls to form)
  const applyBtns = document.querySelectorAll('.js-apply-role');
  const roleSelect = document.getElementById('cr-role');
  const applySection = document.getElementById('apply');

  applyBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const roleName = btn.getAttribute('data-role') || '';

      if (roleSelect && roleName) {
        let matchFound = false;
        for (let i = 0; i < roleSelect.options.length; i++) {
          if (roleSelect.options[i].value === roleName || roleSelect.options[i].text.includes(roleName)) {
            roleSelect.selectedIndex = i;
            matchFound = true;
            break;
          }
        }
        if (!matchFound) {
          // If custom, set value
          roleSelect.value = roleName;
        }
      }

      if (applySection) {
        applySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        const nameInput = document.getElementById('cr-name');
        if (nameInput) {
          setTimeout(() => nameInput.focus(), 600);
        }
      }
    });
  });

  // 4. File Upload Preview & Drag and Drop
  const fileInput = document.getElementById('cr-resume');
  const uploadBox = document.querySelector('.cr-upload-box');
  const fileNameDisplay = document.querySelector('.cr-upload-name');

  if (fileInput && uploadBox && fileNameDisplay) {
    fileInput.addEventListener('change', function () {
      if (this.files && this.files.length > 0) {
        const file = this.files[0];
        const sizeMb = (file.size / (1024 * 1024)).toFixed(1);

        if (file.size > 8 * 1024 * 1024) {
          alert('File is too large. Please select a resume under 8MB.');
          this.value = '';
          fileNameDisplay.style.display = 'none';
          return;
        }

        fileNameDisplay.textContent = '✓ Selected: ' + file.name + ' (' + sizeMb + ' MB)';
        fileNameDisplay.style.display = 'block';
      } else {
        fileNameDisplay.style.display = 'none';
      }
    });

    ['dragenter', 'dragover'].forEach(evt => {
      uploadBox.addEventListener(evt, (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadBox.classList.add('is-dragover');
      });
    });

    ['dragleave', 'drop'].forEach(evt => {
      uploadBox.addEventListener(evt, (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadBox.classList.remove('is-dragover');
      });
    });

    uploadBox.addEventListener('drop', (e) => {
      if (e.dataTransfer && e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        const event = new Event('change');
        fileInput.dispatchEvent(event);
      }
    });
  }

  // 5. Asynchronous Form Submission
  const form = document.getElementById('careersForm');
  const statusBox = document.getElementById('careerStatus');
  const submitBtn = document.getElementById('careerSubmitBtn');

  if (form && statusBox && submitBtn) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();

      statusBox.className = 'cr-status';
      statusBox.style.display = 'none';
      statusBox.textContent = '';

      // Simple client check
      const name = document.getElementById('cr-name').value.trim();
      const email = document.getElementById('cr-email').value.trim();

      if (!name || !email) {
        statusBox.className = 'cr-status is-error';
        statusBox.textContent = 'Please fill in your name and email address.';
        return;
      }

      submitBtn.disabled = true;
      const originalBtnText = submitBtn.innerHTML;
      submitBtn.innerHTML = `
        <svg class="cr-spinner" viewBox="0 0 50 50" style="width:20px;height:20px;animation:spin 1s linear infinite;">
          <circle cx="25" cy="25" r="20" fill="none" stroke="currentColor" stroke-width="4" stroke-dasharray="80" stroke-dashoffset="60"></circle>
        </svg>
        <span>Sending Application...</span>
      `;

      try {
        const formData = new FormData(form);
        const response = await fetch('send-career.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (response.ok && data.ok) {
          statusBox.className = 'cr-status is-success';
          statusBox.textContent = data.message || 'Application submitted successfully! Our team will contact you.';
          form.reset();
          if (fileNameDisplay) {
            fileNameDisplay.style.display = 'none';
          }
        } else {
          statusBox.className = 'cr-status is-error';
          statusBox.textContent = data.message || 'Something went wrong. Please check your information and try again.';
        }
      } catch (err) {
        console.error('Submission error:', err);
        statusBox.className = 'cr-status is-error';
        statusBox.textContent = 'Network error or server unreachable. You can also email us directly at contacts@techbound.in';
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
      }
    });
  }
});
