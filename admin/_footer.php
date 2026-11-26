        </main>
    </div>

    <!-- Live In-App New Enquiry Toast -->
    <div id="adminEnquiryToast" class="fixed bottom-5 right-5 z-50 hidden max-w-sm w-[calc(100%-2.5rem)] bg-white border border-primary/35 shadow-xl rounded-xl p-4">
        <div class="flex items-start gap-3">
            <span class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 mt-0.5">
                <span class="material-symbols-outlined text-[20px]">mark_email_unread</span>
            </span>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold uppercase tracking-wider text-primary">New Enquiry Received</p>
                <p id="adminToastTitle" class="text-sm font-semibold text-on-surface truncate mt-0.5"></p>
                <p id="adminToastSub" class="text-xs text-on-surface-variant truncate"></p>
                <div class="mt-2.5 flex items-center gap-2">
                    <a href="<?= e(admin_url('resources/contact_messages.php')) ?>" class="inline-flex items-center gap-1 px-3 py-1 rounded-md bg-primary text-white text-xs font-medium hover:opacity-90">View Enquiries</a>
                    <button type="button" onclick="document.getElementById('adminEnquiryToast').classList.add('hidden')" class="px-2 py-1 rounded-md text-xs text-outline hover:bg-surface-container">Dismiss</button>
                </div>
            </div>
        </div>
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

      // ===== Live Enquiry Notifications & Unread Badges =====
      (function () {
        const POLL_URL      = <?= json_encode(admin_url('resources/enquiry_poll.php')) ?>;
        const ENQUIRIES_URL = <?= json_encode(admin_url('resources/contact_messages.php')) ?>;
        const ICON_URL      = <?= json_encode(asset('assets/favicon.png')) ?>;
        const STORAGE_KEY   = 'tb_admin_last_enquiry_id';
        const DISMISS_KEY   = 'tb_admin_notif_dismissed';

        window.updateAdminUnreadBadges = function (count) {
          const n = Math.max(0, parseInt(count || 0, 10));
          const sideBadge = document.getElementById('adminEnquiriesBadge');
          const topDot    = document.getElementById('adminNotifDot');
          if (sideBadge) {
            sideBadge.textContent = n > 99 ? '99+' : String(n);
            sideBadge.classList.toggle('hidden', n === 0);
          }
          if (topDot) {
            topDot.textContent = n > 99 ? '99+' : String(n);
            topDot.classList.toggle('hidden', n === 0);
            topDot.classList.toggle('flex', n > 0);
          }
        };

        function syncNotifUI() {
          const banner = document.getElementById('adminNotifBanner');
          const icon   = document.getElementById('adminNotifIcon');
          const label  = document.getElementById('adminNotifLabel');
          if (!('Notification' in window)) {
            if (banner) banner.classList.add('hidden');
            return;
          }
          const perm = Notification.permission;
          if (perm === 'granted') {
            if (banner) banner.classList.add('hidden');
            if (icon)  { icon.textContent = 'notifications_active'; icon.classList.add('text-primary'); }
            if (label) label.textContent = 'Alerts On';
          } else if (perm === 'denied') {
            if (banner) banner.classList.add('hidden');
            if (icon)  { icon.textContent = 'notifications_off'; icon.classList.remove('text-primary'); }
            if (label) label.textContent = 'Blocked';
          } else {
            if (banner && !sessionStorage.getItem(DISMISS_KEY)) {
              banner.classList.remove('hidden');
            }
            if (icon)  { icon.textContent = 'notifications'; icon.classList.remove('text-primary'); }
            if (label) label.textContent = 'Enable Alerts';
          }
        }

        window.dismissNotifBanner = function () {
          sessionStorage.setItem(DISMISS_KEY, '1');
          const banner = document.getElementById('adminNotifBanner');
          if (banner) banner.classList.add('hidden');
        };

        window.requestAdminNotifPermission = function () {
          if (!('Notification' in window)) return;
          Notification.requestPermission().then(function (perm) {
            syncNotifUI();
            if (perm === 'granted') {
              try {
                new Notification('TechBound Enquiry Alerts Enabled', {
                  body: 'You will be notified here whenever a new enquiry arrives.',
                  icon: ICON_URL
                });
              } catch (e) {}
            }
          });
        };

        window.handleAdminNotifClick = function () {
          if ('Notification' in window && Notification.permission === 'default') {
            window.requestAdminNotifPermission();
          } else {
            window.location.href = ENQUIRIES_URL;
          }
        };

        function playChime() {
          try {
            const Ctx = window.AudioContext || window.webkitAudioContext;
            if (!Ctx) return;
            const ctx = new Ctx();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(880, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(1174.66, ctx.currentTime + 0.14);
            gain.gain.setValueAtTime(0.08, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.35);
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.36);
          } catch (e) {}
        }

        function triggerNewEnquiryAlert(latest) {
          if (!latest) return;
          const title = 'New Enquiry from ' + (latest.name || 'Website Visitor');
          const sub   = (latest.company ? latest.company + ' · ' : '') + (latest.email || '');

          // 1. In-app toast
          const toast = document.getElementById('adminEnquiryToast');
          const tTitle = document.getElementById('adminToastTitle');
          const tSub   = document.getElementById('adminToastSub');
          if (toast && tTitle && tSub) {
            tTitle.textContent = latest.name || 'New Enquiry';
            tSub.textContent   = sub || 'Submitted just now';
            toast.classList.remove('hidden');
          }
          playChime();

          // 2. Native browser notification
          if ('Notification' in window && Notification.permission === 'granted') {
            try {
              const n = new Notification(title, {
                body: sub || 'Click to view enquiry details in TechBound Admin.',
                icon: ICON_URL,
                tag: 'tb-enquiry-' + latest.id
              });
              n.onclick = function () {
                window.focus();
                window.location.href = ENQUIRIES_URL;
                n.close();
              };
            } catch (e) {}
          }
        }

        async function pollEnquiries() {
          try {
            const res = await fetch(POLL_URL, { credentials: 'same-origin', cache: 'no-store' });
            if (!res.ok) return;
            const data = await res.json();
            if (!data || !data.ok) return;

            window.updateAdminUnreadBadges(data.unread_count);

            const latestId = parseInt(data.latest_id || 0, 10);
            const storedRaw = localStorage.getItem(STORAGE_KEY);
            if (storedRaw === null) {
              localStorage.setItem(STORAGE_KEY, String(latestId));
            } else {
              const lastSeen = parseInt(storedRaw, 10) || 0;
              if (latestId > lastSeen) {
                localStorage.setItem(STORAGE_KEY, String(latestId));
                triggerNewEnquiryAlert(data.latest);
              }
            }
          } catch (e) {}
        }

        syncNotifUI();
        pollEnquiries();
        setInterval(pollEnquiries, 12000);
      })();
    </script>
</body>
</html>
