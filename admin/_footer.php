        </main>
    </div>
    
    <!-- Responsive Drawer & Dashboard Helper Scripts -->
    <script>
      function toggleAdminSidebar(open) {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('adminSidebarBackdrop');
        if (!sidebar || !backdrop) return;
        
        if (open) {
          sidebar.classList.remove('-translate-x-full');
          sidebar.classList.add('translate-x-0');
          backdrop.classList.remove('hidden');
          document.body.classList.add('overflow-hidden', 'lg:overflow-auto');
        } else {
          sidebar.classList.remove('translate-x-0');
          sidebar.classList.add('-translate-x-full');
          backdrop.classList.add('hidden');
          document.body.classList.remove('overflow-hidden', 'lg:overflow-auto');
        }
      }

      // Close mobile drawer on Escape key
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') toggleAdminSidebar(false);
      });

      // Micro-Interactions Script for Stat Count-Up
      (function initDashboardCounters() {
        const counters = document.querySelectorAll('[data-counter]');
        counters.forEach(counter => {
          const target = +counter.getAttribute('data-counter');
          if (isNaN(target)) return;
          let count = 0;
          const speed = target > 1000 ? 50 : 25;
          const step = Math.ceil(target / speed);
          
          const updateCount = () => {
            count += step;
            if (count < target) {
              counter.innerText = count.toLocaleString();
              requestAnimationFrame(updateCount);
            } else {
              counter.innerText = target.toLocaleString();
            }
          };
          requestAnimationFrame(updateCount);
        });
      })();
    </script>
</body>
</html>