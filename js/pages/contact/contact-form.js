

(function () {
  function isTouch() {
    return window.matchMedia('(pointer: coarse)').matches ||
           /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);
  }

  document.querySelectorAll('a[href^="mailto:"]').forEach(function (a) {
    a.addEventListener('click', function (e) {
      if (isTouch()) return;
      e.preventDefault();
      var to = a.getAttribute('href').replace('mailto:', '');
      window.open(
        'https://mail.google.com/mail/?view=cm&fs=1&to=' + encodeURIComponent(to),
        '_blank', 'noopener'
      );
    });
  });
})();



(function () {
  var form = document.getElementById('contactForm');
  if (!form) return;

  var status = document.getElementById('cformStatus');
  var btn = form.querySelector('.cform__submit');

  function setError(input, msg) {
    var f = input.closest('.field');
    f.classList.toggle('has-error', !!msg);
    var e = f.querySelector('.field__error');
    if (e) e.textContent = msg || '';
  }

  function validate() {
    var ok = true;
    var name = form.name, email = form.email, phone = form.phone, msg = form.message;

    if (name.value.trim().length < 2) { setError(name, 'Please enter your name.'); ok = false; }
    else setError(name, '');

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { setError(email, 'Please enter a valid email.'); ok = false; }
    else setError(email, '');

    var digits = phone.value.replace(/\D/g, '');
    if (phone.value && (digits.length < 7 || digits.length > 12)) { setError(phone, 'Please enter a valid number.'); ok = false; }
    else setError(phone, '');

    if (msg.value.trim().length < 10) { setError(msg, 'Please tell us a little about your project.'); ok = false; }
    else setError(msg, '');

    return ok;
  }

  
  form.addEventListener('input', function (e) {
    if (e.target.closest('.field.has-error')) setError(e.target, '');
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    status.className = 'cform__status';
    status.textContent = '';

    if (!validate()) return;
    if (form.website.value) return;           

    btn.classList.add('is-loading');
    btn.disabled = true;

    fetch(form.action, { method: 'POST', body: new FormData(form) })
      .then(function (r) {
        return r.json().catch(function () { return { ok: false, message: 'Unexpected server response.' }; });
      })
      .then(function (data) {
        if (!data || !data.ok) {
          throw new Error((data && data.message) || 'Sorry, something went wrong. Please call or email us directly.');
        }
        form.reset();
        status.className = 'cform__status is-ok';
        status.innerHTML =
          '<strong>Thank you for reaching out!</strong>' +
          '<span>' + (data.message || 'Your message has been sent. Our team will get back to you within one business day.') + '</span>';
        status.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      })
      .catch(function (err) {
        status.className = 'cform__status is-err';
        status.textContent = (err && err.message) ? err.message : 'Sorry, something went wrong. Please call or email us directly.';
      })
      .finally(function () {
        btn.classList.remove('is-loading');
        btn.disabled = false;
      });
  });
})();

/* country code dropdown */
(function () {
  var wrap = document.getElementById('ccode');
  if (!wrap) return;

  var btn   = wrap.querySelector('.ccode__btn');
  var list  = wrap.querySelector('.ccode__list');
  var label = wrap.querySelector('.ccode__value');
  var input = document.getElementById('cf-code');

  function setOpen(open) {
    wrap.classList.toggle('is-open', open);
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  function choose(li) {
    list.querySelectorAll('li').forEach(function (o) { o.removeAttribute('aria-selected'); });
    li.setAttribute('aria-selected', 'true');
    input.value = li.dataset.code;
    label.textContent = li.dataset.code;
    setOpen(false);
    btn.focus();
  }

  btn.addEventListener('click', function () {
    setOpen(!wrap.classList.contains('is-open'));
  });

  list.addEventListener('click', function (e) {
    var li = e.target.closest('li');
    if (li) choose(li);
  });

  list.addEventListener('keydown', function (e) {
    var li = e.target.closest('li');
    if (!li) return;
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); choose(li); }
    if (e.key === 'ArrowDown' && li.nextElementSibling) { e.preventDefault(); li.nextElementSibling.focus(); }
    if (e.key === 'ArrowUp' && li.previousElementSibling) { e.preventDefault(); li.previousElementSibling.focus(); }
  });

  document.addEventListener('click', function (e) {
    if (!wrap.contains(e.target)) setOpen(false);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') setOpen(false);
  });
})();