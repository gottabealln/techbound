<?php

require_once __DIR__ . '/../config/site.php';

// Apply dynamic Service SEO overrides (Meta Title, Meta Description, Primary Keyword, Schema JSON-LD, Image Alt)
$service_seo                   = null;
$primary_keyword               = $primary_keyword ?? '';
$schema_data                   = $schema_data ?? '';
$service_image_alt             = $service_image_alt ?? '';
$service_image_alt_description = $service_image_alt_description ?? '';

if (is_file(__DIR__ . '/service_seo.php')) {
    require_once __DIR__ . '/service_seo.php';
    $service_seo = get_service_seo_by_file($current_page ?? basename($_SERVER['PHP_SELF'] ?? ''));
    if ($service_seo) {
        if (!empty(trim((string)($service_seo['meta_title'] ?? '')))) {
            $page_title = trim((string)$service_seo['meta_title']);
        }
        if (!empty(trim((string)($service_seo['meta_description'] ?? '')))) {
            $page_desc = trim((string)$service_seo['meta_description']);
        }
        if (!empty(trim((string)($service_seo['primary_keyword'] ?? '')))) {
            $primary_keyword = trim((string)$service_seo['primary_keyword']);
        }
        if (!empty(trim((string)($service_seo['schema_data'] ?? '')))) {
            $schema_data = trim((string)$service_seo['schema_data']);
        }
        if (!empty(trim((string)($service_seo['image_alt'] ?? '')))) {
            $service_image_alt = trim((string)$service_seo['image_alt']);
        }
        if (!empty(trim((string)($service_seo['image_alt_description'] ?? '')))) {
            $service_image_alt_description = trim((string)$service_seo['image_alt_description']);
        }
    }
}

$__meta       = resolve_page_meta($page_title ?? ($meta_title ?? null), $page_desc ?? ($meta_desc ?? null));
$page_title   = $__meta['title'];
$page_desc    = $__meta['description'];
$og_type      = !empty($og_type) ? $og_type : 'website';
$header_light = $header_light ?? false;
$page_styles  = $page_styles  ?? [];


$services = [
  'Search' => [
    ['SEO',    'seo',    'Rank higher and get found on Google'],
    ['AI SEO', 'ai-seo', 'Show up in AI answers and generative search'],
  ],
  'Social & Ads' => [
    ['SMM',                'smm',                'Grow and engage your audience on social'],
    ['Online Advertising', 'online-advertising', 'Paid campaigns that bring measurable returns'],
  ],
  'Web & Leads' => [
    ['Website Development', 'website-development', 'Fast, modern sites built to convert'],
    ['Lead Generation',     'lead-generation',     'Turn attention into qualified enquiries'],
  ],
];

$company = [
  ['title' => 'About Techbound',
   'text'  => 'Meet the Trivandrum team helping brands grow with search, social and web.',
   'href'  => 'about.php',
   'img'   => 'assets/mega-about.avif',
   'link'  => 'Learn More ↗'],
  ['title' => 'Careers',
   'text'  => 'Join us and help businesses across Kerala and beyond grow online.',
   'href'  => 'careers.php',
   'img'   => 'assets/mega-careers.avif',
   'link'  => 'View Openings ↗'],
  ['title' => 'Blog',
   'text'  => 'Marketing tips, SEO insights and updates from our team.',
   'href'  => 'blog.php',
   'img'   => 'assets/mega-blog.avif',
   'link'  => 'Read Articles ↗'],
];

$company_links = [
  ['label' => 'Construction', 'href' => 'construction.php'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-WDGF4FS9');</script>
  <!-- End Google Tag Manager -->

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta name="title" content="<?= htmlspecialchars($page_title) ?>">
  <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
  <?php if (!empty($primary_keyword)): ?>
  <meta name="keywords" content="<?= htmlspecialchars($primary_keyword) ?>">
  <?php endif; ?>
  <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
  <meta property="og:type" content="<?= htmlspecialchars($og_type) ?>">
  <?php if (!empty($service_image_alt)): ?>
  <meta property="og:image:alt" content="<?= htmlspecialchars($service_image_alt) ?>">
  <?php endif; ?>
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($page_desc) ?>">
  <?php if (!empty($schema_data)):
    $__decodedSchema = json_decode($schema_data, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($__decodedSchema)):
  ?>
  <script type="application/ld+json"><?= json_encode($__decodedSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
  <?php endif; endif; ?>

  <link rel="icon" type="image/png" href="<?= asset('assets/favicon.png') ?>">
  <link rel="shortcut icon" type="image/png" href="<?= asset('assets/favicon.png') ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= asset('assets/apple-touch-icon.png') ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Lato:wght@400;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

   <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <?php foreach ($page_styles as $css): ?>
  <link rel="stylesheet" href="<?= asset($css) ?>">
  <?php endforeach; ?>
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WDGF4FS9"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <header class="header<?= $header_light ? ' is-light' : '' ?>">
    <nav class="navbar">
      <a href="<?= url('index.php') ?>" class="navbar__logo">
        <img src="<?= url('assets/logo_techbound.png') ?>" alt="TechBound logo">
      </a>

      <ul class="nav-links">
        <li><a href="<?= url('index.php') ?>"<?= current_attr('index.php') ?>>Home</a></li>
       

       

        <!-- ===== SERVICES MEGA MENU ===== -->
        <li class="has-sub has-mega">
          <button class="nav-trigger has-dropdown" type="button" aria-expanded="false" data-mega-trigger="services">
            Services
          </button>

          <div class="mega-menu mega-menu--services" id="servicesMegaMenu">
            <div class="svc-mega">

              <div class="svc-mega__intro">
                <a href="<?= url('services.php') ?>" class="svc-mega__thumb" aria-label="Explore TechBound Services">
                  <img src="<?= url('assets/services.avif') ?>" alt="TechBound Digital Solutions">
                </a>
                <span class="mega-menu__eyebrow">WHAT WE DO</span>
                <h2>Digital Solutions for Business Growth</h2>
                <p>Everything your business needs to build its online presence and reach the right audience.</p>
               <a href="<?= url('services.php') ?>" class="svc-mega__all">
  View All Services
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    <path d="M5 12h14M13 6l6 6-6 6"/>
  </svg>
</a>
              </div>

              <div class="svc-mega__cols">
                <?php foreach ($services as $group => $items): ?>
                <div class="svc-mega__col">
                  <h3><?= htmlspecialchars($group) ?></h3>
                  <ul>
                   <?php foreach ($items as [$name, $id, $desc]): ?>
<li>
  <a href="<?= url($id . '.php') ?>">
    <strong><?= htmlspecialchars($name) ?></strong>
    <span><?= htmlspecialchars($desc) ?></span>
  </a>
</li>
<?php endforeach; ?>
                  </ul>
                </div>
                <?php endforeach; ?>
              </div>

            </div>
          </div>
        </li>


       <?php /* <li><a href="<?= url('portfolio.php') ?>"<?= current_attr('portfolio.php') ?>>Portfolio</a></li> */ ?>

      <!-- ===== COMPANY MEGA MENU ===== -->
<li class="has-sub has-mega">
  <button class="nav-trigger has-dropdown" type="button" aria-expanded="false" data-mega-trigger="work"<?= current_attr('about.php', 'careers.php', 'blog.php') ?>>
    Company
  </button>

  <div class="mega-menu" id="workMegaMenu">
    <div class="cmenu">

      <div class="cmenu__side">
        <h3 class="cmenu__heading">Industries</h3>
        <ul class="cmenu__links">
          <?php foreach ($company_links as $l): ?>
            <li><a href="<?= url($l['href']) ?>"><?= $l['label'] ?></a></li>
          <?php endforeach; ?>
        </ul>
        
      </div>

      <div class="cmenu__cards">
        <div class="mega-menu__grid">
          <?php foreach ($company as $c): ?>
            <div class="mega-card">
              <a href="<?= url($c['href']) ?>" class="mega-card__image">
                <img src="<?= url($c['img']) ?>" alt="<?= $c['title'] ?>">
              </a>
              <h3><?= $c['title'] ?></h3>
              <p><?= $c['text'] ?></p>
              <a href="<?= url($c['href']) ?>" class="mega-card__link"><?= $c['link'] ?></a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</li>
        <li><a href="<?= url('contact.php') ?>"<?= current_attr('contact.php') ?>>Contact</a></li>
      </ul>

      <div class="navbar__actions">
        <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--sm btn--arrow navbar__cta">Talk to an expert</a>

        <button id="menuBtn" class="menu-btn" type="button" aria-expanded="false" aria-label="Menu">
          <svg viewBox="0 0 24 24" fill="#000" aria-hidden="true">
            <path d="M3 4h18v2H3V4zm6 7h12v2H9v-2zm-6 7h18v2H3v-2z"/>
          </svg>
        </button>
      </div>
    </nav>

    <!-- ===== MOBILE MENU ===== -->
    <div id="mobileMenu" class="mobile-menu">
      <ul>
        <li><a href="<?= url('index.php') ?>"<?= current_attr('index.php') ?>>Home</a></li>

        <!-- ===== SERVICES MOBILE (SEPARATE SECTIONS) ===== -->
        <li class="has-sub">
          <button class="nav-trigger has-dropdown" type="button" aria-expanded="false">Services</button>
          <div class="m-sub m-services-sub">
            <?php foreach ($services as $group => $items): ?>
              <div class="m-group">
                <span class="m-group__title"><?= htmlspecialchars($group) ?></span>
                <ul class="m-group__list">
                  <?php foreach ($items as [$name, $id, $desc]): ?>
                    <li>
                      <a href="<?= url($id . '.php') ?>" class="m-service-link">
                        <strong class="m-service-link__name"><?= htmlspecialchars($name) ?></strong>
                        <?php if (!empty($desc)): ?>
                          <span class="m-service-link__desc"><?= htmlspecialchars($desc) ?></span>
                        <?php endif; ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endforeach; ?>
            <div class="m-services-footer">
              <a href="<?= url('services.php') ?>" class="m-view-all">
                <span>View All Services Overview</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </a>
            </div>
          </div>
        </li>

        <?php /* <li><a href="<?= url('portfolio.php') ?>"<?= current_attr('portfolio.php') ?>>Portfolio</a></li> */ ?>

        <!-- ===== COMPANY MOBILE (SEPARATE SECTIONS) ===== -->
        <li class="has-sub">
          <button class="nav-trigger has-dropdown" type="button" aria-expanded="false">Company</button>
          <div class="m-sub m-company-sub">
            <div class="m-group">
              <span class="m-group__title">Industries</span>
              <ul class="m-group__list">
                <?php foreach ($company_links as $l): ?>
                  <li>
                    <a href="<?= url($l['href']) ?>" class="m-service-link">
                      <strong class="m-service-link__name"><?= htmlspecialchars($l['label']) ?></strong>
                      <span class="m-service-link__desc">Specialized marketing for builders &amp; developers</span>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
            <div class="m-group">
              <span class="m-group__title">Company Pages</span>
              <ul class="m-group__list">
                <?php foreach ($company as $c): ?>
                  <li>
                    <a href="<?= url($c['href']) ?>" class="m-service-link">
                      <strong class="m-service-link__name"><?= htmlspecialchars($c['title']) ?></strong>
                      <span class="m-service-link__desc"><?= htmlspecialchars($c['text']) ?></span>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </li>

        <li><a href="<?= url('contact.php') ?>"<?= current_attr('contact.php') ?>>Contact</a></li>
      </ul>

      <!-- Follow Us Social Links on Mobile Menu -->
      <div class="mobile-social">
        <span class="mobile-social__title">Follow Us</span>
        <div class="mobile-social__links">
          <a href="https://www.facebook.com/techboundDigitalAgency" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="http://instagram.com/techboundinnovations/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.351-.2 6.78-2.618 6.98-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="https://www.linkedin.com/company/techboundinnovations" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a href="https://x.com/techbounddgtl" target="_blank" rel="noopener noreferrer" aria-label="X">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
          </a>
          <a href="https://www.threads.com/@techboundinnovations" target="_blank" rel="noopener noreferrer" aria-label="Threads">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.186 24c-3.606 0-6.529-1.182-8.457-3.419C1.8 18.344 1 15.316 1 11.83 1 8.344 1.848 5.334 3.748 3.107 5.65.88 8.653 0 12.247 0c3.545 0 6.452.898 8.406 2.597 1.954 1.7 2.947 4.256 2.947 7.595 0 2.21-.497 4.14-1.49 5.792-.994 1.652-2.392 2.87-4.195 3.655-1.803.785-3.924 1.177-6.363 1.177-.662 0-1.32-.03-1.974-.09-.044.403-.066.81-.066 1.22 0 1.874.57 3.327 1.71 4.36 1.14 1.033 2.68 1.55 4.62 1.55 1.547 0 2.973-.34 4.278-1.02v2.38c-1.393.593-2.92.89-4.58.89l-.348-.106zM13.2 7.71c-1.19 0-2.18.396-2.97 1.188-.79.792-1.185 1.782-1.185 2.97 0 1.188.395 2.178 1.185 2.97.79.792 1.78 1.188 2.97 1.188 1.188 0 2.178-.396 2.97-1.188.792-.792 1.188-1.782 1.188-2.97 0-1.188-.396-2.178-1.188-2.97-.792-.792-1.782-1.188-2.97-1.188z"/></svg>
          </a>
          <a href="https://www.youtube.com/@techboundinnovations1257" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
        </div>
      </div>

      <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--sm btn--arrow btn--block">Talk to an expert</a>
    </div>

    <!-- ===== DESKTOP CONTACT DETAILS DRAWER ===== -->
    <div id="contactDrawerBackdrop" class="contact-drawer-backdrop" aria-hidden="true"></div>
    <aside id="contactDrawer" class="contact-drawer" aria-label="Contact Information" aria-hidden="true">
      <div class="contact-drawer__header">
        <a href="<?= url('index.php') ?>" class="contact-drawer__logo" aria-label="TechBound Innovations Home">
          <img src="<?= url('assets/logo_techbound.png') ?>" alt="TechBound Innovations">
        </a>
        <button type="button" id="contactDrawerClose" class="contact-drawer__close" aria-label="Close Contact Panel">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
      </div>

      <div class="contact-drawer__body">
        <p class="contact-drawer__intro">
          TechBound Innovations enables organisations to scale with clarity and control by integrating data-driven SEO, performance marketing, and modern web solutions.
        </p>

        <hr class="contact-drawer__divider">

        <div class="contact-drawer__cards">
          <!-- Phone Card -->
          <div class="c-drawer-card">
            <div class="c-drawer-card__icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
            </div>
            <div class="c-drawer-card__content">
              <span class="c-drawer-card__label">PHONE</span>
              <div class="c-drawer-card__values">
                <a href="tel:+918606497677" class="c-drawer-card__link">+91 86064 97677</a>
              </div>
            </div>
          </div>

          <!-- Email Card -->
          <div class="c-drawer-card">
            <div class="c-drawer-card__icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <path d="m22 7-10 6L2 7"/>
              </svg>
            </div>
            <div class="c-drawer-card__content">
              <span class="c-drawer-card__label">EMAIL</span>
              <div class="c-drawer-card__values">
                <a href="mailto:contacts@techbound.in" class="c-drawer-card__link">contacts@techbound.in</a>
              </div>
            </div>
          </div>

          <!-- Office Card -->
          <div class="c-drawer-card">
            <div class="c-drawer-card__icon">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
            </div>
            <div class="c-drawer-card__content">
              <span class="c-drawer-card__label">OFFICE</span>
              <p class="c-drawer-card__text">
                6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Statue, Thiruvananthapuram, Kerala 695001
              </p>
              <a href="https://maps.google.com/?q=TechBound+Digital+Marketing+Agency+Trivandrum" target="_blank" rel="noopener" class="c-drawer-card__maplink">
                View on Google Maps &rarr;
              </a>
            </div>
          </div>
        </div>

        <!-- Follow Us Section in Contact Drawer -->
        <div class="c-drawer-social">
          <span class="c-drawer-social__title">Follow Us</span>
          <div class="c-drawer-social__links">
            <a href="https://www.facebook.com/techboundDigitalAgency" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="http://instagram.com/techboundinnovations/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.351-.2 6.78-2.618 6.98-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
            </a>
            <a href="https://www.linkedin.com/company/techboundinnovations" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
            </a>
            <a href="https://x.com/techbounddgtl" target="_blank" rel="noopener noreferrer" aria-label="X">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
            </a>
            <a href="https://www.threads.com/@techboundinnovations" target="_blank" rel="noopener noreferrer" aria-label="Threads">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.186 24c-3.606 0-6.529-1.182-8.457-3.419C1.8 18.344 1 15.316 1 11.83 1 8.344 1.848 5.334 3.748 3.107 5.65.88 8.653 0 12.247 0c3.545 0 6.452.898 8.406 2.597 1.954 1.7 2.947 4.256 2.947 7.595 0 2.21-.497 4.14-1.49 5.792-.994 1.652-2.392 2.87-4.195 3.655-1.803.785-3.924 1.177-6.363 1.177-.662 0-1.32-.03-1.974-.09-.044.403-.066.81-.066 1.22 0 1.874.57 3.327 1.71 4.36 1.14 1.033 2.68 1.55 4.62 1.55 1.547 0 2.973-.34 4.278-1.02v2.38c-1.393.593-2.92.89-4.58.89l-.348-.106zM13.2 7.71c-1.19 0-2.18.396-2.97 1.188-.79.792-1.185 1.782-1.185 2.97 0 1.188.395 2.178 1.185 2.97.79.792 1.78 1.188 2.97 1.188 1.188 0 2.178-.396 2.97-1.188.792-.792 1.188-1.782 1.188-2.97 0-1.188-.396-2.178-1.188-2.97-.792-.792-1.782-1.188-2.97-1.188z"/></svg>
            </a>
            <a href="https://www.youtube.com/@techboundinnovations1257" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
            </a>
          </div>
        </div>

        <div class="contact-drawer__cta">
          <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow btn--block">Talk to an expert</a>
        </div>
      </div>
    </aside>
  </header>