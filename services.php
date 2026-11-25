<?php
$page_title   = 'Digital Marketing Services in Trivandrum, Kerala | TechBound';
$page_desc    = 'Explore TechBound\'s comprehensive digital services: SEO, AI SEO, PPC advertising, social media marketing, web development, and lead generation in Trivandrum, Kerala.';
$slug         = 'services';
$page_styles  = ['css/services.css'];


$service_blocks = [
  [
    'id'    => 'seo',
    'title' => 'Search Engine Optimization (SEO)',
    'intro' => 'Increase your visibility on Google with strategies that bring qualified traffic to your website.',
    'items' => ['Technical SEO', 'On-Page SEO', 'Local SEO', 'Ecommerce SEO', 'Keyword & Content Strategy'],
  ],
  [
    'id'    => 'ai-seo',
    'title' => 'AI SEO',
    'intro' => 'Make your brand visible in AI answers and generative search, not only in classic rankings.',
    'items' => ['Generative Engine Optimization', 'AI Search Visibility', 'Structured Data & Schema', 'Content for AI Answers'],
  ],
  [
    'id'    => 'smm',
    'title' => 'Social Media Marketing',
    'intro' => 'Create engaging content, grow your audience and turn followers into customers.',
    'items' => ['Content Strategy', 'Social Media Management', 'Community Engagement', 'Brand Growth'],
  ],
  [
    'id'    => 'online-advertising',
    'title' => 'Online Advertising',
    'intro' => 'Launch campaigns that generate quality leads and maximise your return on ad spend.',
    'items' => ['Google Ads', 'Meta Ads', 'Performance Marketing', 'Remarketing', 'Conversion Tracking'],
  ],
  [
    'id'    => 'website-development',
    'title' => 'Website Development',
    'intro' => 'Fast, responsive, SEO-friendly websites designed to turn visitors into customers.',
    'items' => ['Business Websites', 'WordPress Development', 'Custom Web Development', 'Ecommerce Development', 'UI/UX Design'],
  ],
  [
    'id'    => 'lead-generation',
    'title' => 'Lead Generation',
    'intro' => 'Turn attention into qualified enquiries with funnels built around your business goals.',
    'items' => ['Landing Pages', 'Lead Funnels', 'Marketing Consulting', 'Analytics & Reporting'],
  ],
];

require __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero hero--inner" style="background-image: url('<?= asset('assets/services.avif') ?>');">
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <div class="hero__tagline-wrap">
      <nav class="hero__crumbs" aria-label="Breadcrumb">
        <a href="<?= url('index.php') ?>">Home</a><span>/</span>
        <span class="is-current">Services</span>
      </nav>
      <div class="hero__line"></div>
    </div>

    <div class="hero__body">
      <div class="hero__text">
        <h1 class="hero__title">Clear, Proven Digital Marketing Services</h1>
        <p class="hero__desc">
          From technical SEO and AI search visibility to high-converting PPC advertising and modern web engineering, we deliver end-to-end digital growth from Trivandrum.
        </p>
      </div>

      <div class="hero__buttons">
        <a href="<?= url('contact.php') ?>" class="btn btn--primary btn--arrow" data-book-call>Talk to an Expert</a>
        <a href="#seo" class="btn btn--outline btn--arrow">Explore Services</a>
      </div>
    </div>
  </div>
</section>

<!-- Service blocks -->
<?php foreach ($service_blocks as $n => $s):
  $num    = str_pad($n + 1, 2, '0', STR_PAD_LEFT);
  $imgRel = 'assets/services/' . $s['id'] . '.jpg';
  $vidRel = 'assets/services/' . $s['id'] . '.mp4';
  $hasImg = is_file(__DIR__ . '/' . $imgRel);
  $hasVid = is_file(__DIR__ . '/' . $vidRel);
?>
<section class="svc-block<?= $n % 2 ? ' svc-block--alt' : '' ?>" id="<?= $s['id'] ?>" data-nav="light">
  <div class="svc-block__inner">

    <div class="svc-block__content">
      <span class="pill pill--glow" data-animate="up">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l2.4 7.6L22 12l-7.6 2.4L12 22l-2.4-7.6L2 12l7.6-2.4z"/></svg>
        Service <?= $num ?>
      </span>

      <h2 class="svc-block__title" data-animate="up">
        <a href="<?= url($s['id'] . '.php') ?>" class="svc-block__title-link"><?= htmlspecialchars($s['title']) ?></a>
      </h2>
      <p class="svc-block__intro" data-animate="up"><?= htmlspecialchars($s['intro']) ?></p>

      <ul class="svc-block__list">
        <?php foreach ($s['items'] as $item): ?>
        <li data-animate="up"><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
      </ul>

      <div class="svc-block__cta" data-animate="up">
        <a href="<?= url($s['id'] . '.php') ?>" class="btn btn--primary btn--sm btn--arrow">
          <span>Explore <?= htmlspecialchars($s['title']) ?></span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
      </div>
    </div>

    <div class="svc-block__media" data-animate="up">
      <?php
        $__svcSeo = function_exists('get_service_seo_by_file') ? get_service_seo_by_file($s['id'] . '.php') : null;
        $__svcAlt = !empty($__svcSeo['image_alt']) ? $__svcSeo['image_alt'] : $s['title'];
      ?>
      <?php if ($hasImg): ?>
        <img src="<?= asset($imgRel) ?>" alt="<?= htmlspecialchars($__svcAlt) ?>" loading="lazy">
      <?php else: ?>
        <div class="svc-block__placeholder" aria-hidden="true"><span><?= $num ?></span></div>
      <?php endif; ?>
    </div>

  </div>
</section>
<?php endforeach; ?>

<?php
$faq_page  = 'services';
$faq_title = 'Questions About Our Services';
require __DIR__ . '/includes/faq-section.php';
?>

<?php require __DIR__ . '/includes/footer.php'; ?>