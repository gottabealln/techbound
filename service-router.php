<?php
/**
 * Dynamic Service Slug Router
 * Resolves custom service slugs modified from the Admin CMS (/admin/services/)
 * to their backing PHP template file.
 */
require_once __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/service_seo.php';

$route = trim((string)($_GET['route'] ?? ''), '/');
$match = get_service_seo_by_slug($route);

if ($match && !empty($match['page_file'])) {
    $targetFile = basename($match['page_file']);
    $fullPath   = __DIR__ . '/' . $targetFile;
    if (is_file($fullPath) && pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
        // Ensure header.php and current_attr() see the resolved template filename
        $current_page = $targetFile;
        require $fullPath;
        exit;
    }
}

http_response_code(404);
$page_title   = 'Page Not Found | TechBound';
$page_desc    = 'The page you are looking for could not be found. Explore TechBound\'s digital marketing services in Trivandrum, Kerala.';
$header_light = false;
require __DIR__ . '/includes/header.php';
?>
<section class="hero hero--inner" style="background-image: url('<?= asset('assets/hero.avif') ?>');" data-nav="dark">
  <div class="hero__overlay"></div>
  <div class="hero__content">
    <div class="hero__body">
      <div class="hero__text">
        <h1 class="hero__title">Page Not Found</h1>
        <p class="hero__desc">The page you requested may have moved to a new URL. Explore our services or head back to the home page.</p>
      </div>
      <div class="hero__buttons">
        <a href="<?= url('index.php') ?>" class="btn btn--primary btn--arrow">Back to Home</a>
        <a href="<?= url('services.php') ?>" class="btn btn--outline btn--arrow">View Services</a>
      </div>
    </div>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
