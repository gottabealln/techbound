    (function () {
      var desktopNav = document.querySelector('.nav-links');

      function closeSubs(scope) {
        scope.querySelectorAll('.has-sub.is-open').forEach(function (li) {
          li.classList.remove('is-open');
          li.querySelector('.nav-trigger').setAttribute('aria-expanded', 'false');
        });
      }

      document.addEventListener('click', function (e) {
        var trigger = e.target.closest('.nav-trigger');

        if (trigger) {
          var li = trigger.closest('.has-sub');
          var willOpen = !li.classList.contains('is-open');
          closeSubs(li.parentElement);            
          if (willOpen) {
            li.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
          }
          return;
        }

       
        if (!e.target.closest('.dropdown') || e.target.closest('.dropdown a')) {
          closeSubs(desktopNav);
        }
      });

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeSubs(desktopNav);
      });

      window.addEventListener('scroll', function () {
        closeSubs(desktopNav);
      }, { passive: true });
    })();
 