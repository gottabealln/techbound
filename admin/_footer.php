        </main>
    </div>

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

      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') toggleAdminSidebar(false);
      });
    </script>
</body>
</html>
