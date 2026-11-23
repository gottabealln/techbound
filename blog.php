<?php
require_once __DIR__ . '/config/site.php';

// If a slug is requested via blog.php?slug=..., route to single post view
if (!empty($_GET['slug'])) {
    require __DIR__ . '/blog-post.php';
    exit;
}

$page_title   = 'Blog & Digital Insights | TechBound Innovations';
$page_desc    = 'Read the latest guides, search algorithm updates, AI SEO strategies, and digital marketing insights from the TechBound team in Trivandrum, Kerala.';
$page_styles  = ['css/blog.css'];
$page_slug    = 'blog';
$show_faq_btn = false;

// Helper to fetch posts (DB with PHP array & JSON fallback)
function get_all_posts(): array {
    static $cached = null;
    if ($cached !== null) return $cached;

    $posts = [];
    try {
        require_once __DIR__ . '/includes/db.php';
        $pdo = db();
        $stmt = $pdo->query("SELECT id, title, slug, category, tags, author, author_designation, excerpt, image, published_at, active FROM blog_posts WHERE active = 1 ORDER BY published_at DESC, id DESC");
        $posts = $stmt->fetchAll();
    } catch (Throwable $e) {
        $posts = [];
    }

    // Fallback 1: Precompiled PHP data array (guaranteed zero downtime, zero parse overhead on any host)
    if (empty($posts)) {
        $phpDataPath = __DIR__ . '/data/blogs_index.php';
        if (file_exists($phpDataPath)) {
            $data = require $phpDataPath;
            if (is_array($data) && !empty($data)) {
                $posts = array_filter($data, fn($p) => ($p['active'] ?? 1) == 1);
            }
        }
    }

    // Fallback 2: Local JSON file
    if (empty($posts)) {
        foreach ([__DIR__ . '/techbound_blogs.json', __DIR__ . '/data/techbound_blogs.json'] as $jsonPath) {
            if (file_exists($jsonPath)) {
                $data = json_decode(file_get_contents($jsonPath), true);
                if (is_array($data) && !empty($data)) {
                    $posts = array_filter($data, fn($p) => ($p['active'] ?? 1) == 1);
                    usort($posts, fn($a, $b) => strcmp($b['published_at'] ?? '', $a['published_at'] ?? ''));
                    break;
                }
            }
        }
    }

    $cached = $posts;
    return $posts;
}

$all_posts = get_all_posts();

// Categories list with counts
$categories = [];
foreach ($all_posts as $p) {
    $c = $p['category'] ?? 'Digital Marketing';
    $categories[$c] = ($categories[$c] ?? 0) + 1;
}
arsort($categories);

// Current filter parameters
$selected_cat = trim($_GET['cat'] ?? 'All');
$search_query = trim($_GET['q'] ?? '');
$current_page = max(1, (int)($_GET['page'] ?? 1));
$per_page     = 12;

// Filter posts
$filtered = array_filter($all_posts, function($p) use ($selected_cat, $search_query) {
    if ($selected_cat !== 'All' && ($p['category'] ?? '') !== $selected_cat) {
        return false;
    }
    if ($search_query !== '') {
        $text = strtolower(($p['title'] ?? '') . ' ' . ($p['excerpt'] ?? '') . ' ' . ($p['body'] ?? ''));
        if (strpos($text, strtolower($search_query)) === false) {
            return false;
        }
    }
    return true;
});

// Featured post: first post if on page 1 with no search filter
$featured_post = null;
$grid_posts = array_values($filtered);
if ($current_page === 1 && empty($search_query) && $selected_cat === 'All' && !empty($all_posts)) {
    $featured_post = $all_posts[0];
    // Exclude featured post before paginating so page 1 has a clean 4-column grid (12 cards)
    $grid_posts = array_values(array_filter($grid_posts, fn($p) => $p['id'] !== $featured_post['id']));
}

$total_filtered = count($filtered);
$total_grid     = count($grid_posts);
$total_pages    = max(1, (int)ceil($total_grid / $per_page));
if ($current_page > $total_pages) $current_page = $total_pages;

$offset       = ($current_page - 1) * $per_page;
$paged_posts  = array_slice($grid_posts, $offset, $per_page);

include __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO ===== -->
<section class="hero hero--inner" style="background-image: url('<?= asset('assets/mega-blog.avif') ?>');">
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <div class="hero__tagline-wrap">
      <nav class="hero__crumbs" aria-label="Breadcrumb">
        <a href="<?= url('index.php') ?>">Home</a><span>/</span>
        <span class="is-current">Blog</span>
      </nav>
      <div class="hero__line"></div>
    </div>

    <div class="hero__body">
      <div class="hero__text">
        <h1 class="hero__title">Insights, Strategies &amp; Digital Growth</h1>
        <p class="hero__desc">
          Practical guides, search updates, and growth strategies crafted by our search, web, and performance marketing specialists.
        </p>
      </div>

      <!-- Search Form -->
      <div class="blog-search-wrap" style="width: 100%; max-width: 580px; margin-top: 8px;">
        <form action="<?= url('blog.php') ?>" method="GET" class="blog-search-form" style="background: rgba(255, 255, 255, 0.12); border-color: rgba(255, 255, 255, 0.25);">
          <?php if ($selected_cat !== 'All'): ?>
            <input type="hidden" name="cat" value="<?= htmlspecialchars($selected_cat) ?>">
          <?php endif; ?>
          <input type="text" name="q" value="<?= htmlspecialchars($search_query) ?>" placeholder="Search 260+ articles by topic, keyword..." class="blog-search-input" aria-label="Search articles" style="color: #fff;">
          <button type="submit" class="blog-search-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            Search
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ===== FEATURED POST (HERO BANNER) ===== -->
<?php if ($featured_post): ?>
<section class="blog-featured-section">
  <article class="blog-featured-card">
    <a href="<?= url('blog-post.php?slug=' . urlencode($featured_post['slug'])) ?>" class="blog-featured-img-wrap" aria-label="<?= htmlspecialchars($featured_post['title']) ?>">
      <img src="<?= htmlspecialchars(blog_image_url($featured_post['image'] ?? '', $featured_post['category'] ?? null)) ?>" alt="<?= htmlspecialchars($featured_post['title']) ?>" loading="eager" onerror="this.onerror=null; this.src='<?= asset(blog_placeholder($featured_post['category'] ?? null)) ?>';">
    </a>
    <div class="blog-featured-content">
      <div class="blog-featured-meta">
        <span class="blog-cat-pill"><?= htmlspecialchars($featured_post['category']) ?></span>
        <span class="blog-featured-date"><?= date('F j, Y', strtotime($featured_post['published_at'])) ?></span>
      </div>
      <h2 class="blog-featured-title">
        <a href="<?= url('blog-post.php?slug=' . urlencode($featured_post['slug'])) ?>"><?= htmlspecialchars($featured_post['title']) ?></a>
      </h2>
      <p class="blog-featured-excerpt"><?= htmlspecialchars($featured_post['excerpt']) ?></p>
      <div class="blog-featured-footer">
        <div class="blog-author">
          <span class="blog-author-avatar" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </span>
          <div class="blog-author-info">
            <span class="blog-author-name"><?= htmlspecialchars($featured_post['author'] ?? 'TechBound Team') ?></span>
            <span class="blog-author-role"><?= htmlspecialchars(!empty($featured_post['author_designation']) ? $featured_post['author_designation'] : 'Digital Marketing Specialist') ?></span>
          </div>
        </div>
        <a href="<?= url('blog-post.php?slug=' . urlencode($featured_post['slug'])) ?>" class="blog-read-link">
          Read Article
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>
    </div>
  </article>
</section>
<?php endif; ?>

<!-- ===== MAIN BLOG LISTING ===== -->
<section class="blog-main-section">
  <div class="blog-container">

    <?php if ($search_query): ?>
      <div class="blog-filters-bar">
        <div class="blog-results-count">
          Found <strong><?= $total_filtered ?></strong> results for "<em><?= htmlspecialchars($search_query) ?></em>" · <a href="<?= url('blog.php') ?>" style="color:var(--brand);text-decoration:underline;">Clear Search</a>
        </div>
      </div>
    <?php endif; ?>

    <!-- Cards Grid -->
    <?php if (!empty($paged_posts)): ?>
      <div class="blog-grid">
        <?php foreach ($paged_posts as $post): ?>
          <article class="blog-card">
            <a href="<?= url('blog-post.php?slug=' . urlencode($post['slug'])) ?>" class="blog-card__media">
              <img src="<?= htmlspecialchars(blog_image_url($post['image'] ?? '', $post['category'] ?? null)) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy" onerror="this.onerror=null; this.src='<?= asset(blog_placeholder($post['category'] ?? null)) ?>';">
            </a>
            <div class="blog-card__body">
              <div class="blog-card__meta">
                <span class="blog-cat-pill"><?= htmlspecialchars($post['category'] ?? 'Digital Marketing') ?></span>
                <span style="font-size:12.5px;color:var(--blog-muted);"><?= date('M j, Y', strtotime($post['published_at'])) ?></span>
              </div>
              <h3 class="blog-card__title">
                <a href="<?= url('blog-post.php?slug=' . urlencode($post['slug'])) ?>"><?= htmlspecialchars($post['title']) ?></a>
              </h3>
              <p class="blog-card__excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
              <div class="blog-card__footer">
                <div class="blog-author blog-author--compact">
                  <span class="blog-author-avatar" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  </span>
                  <div class="blog-author-info">
                    <span class="blog-author-name"><?= htmlspecialchars($post['author'] ?? 'TechBound Team') ?></span>
                    <span class="blog-author-role"><?= htmlspecialchars(!empty($post['author_designation']) ? $post['author_designation'] : 'Digital Marketing Specialist') ?></span>
                  </div>
                </div>
                <a href="<?= url('blog-post.php?slug=' . urlencode($post['slug'])) ?>" class="blog-read-link">
                  Read
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if ($total_pages > 1): ?>
        <nav class="blog-pagination" aria-label="Pagination">
          <?php
            $q_params = [];
            if ($selected_cat !== 'All') $q_params['cat'] = $selected_cat;
            if ($search_query !== '')   $q_params['q']   = $search_query;

            $build_url = function($p) use ($q_params) {
              $params = $q_params;
              $params['page'] = $p;
              return url('blog.php?' . http_build_query($params));
            };
          ?>

          <!-- Prev Page -->
          <a href="<?= $build_url(max(1, $current_page - 1)) ?>" class="blog-page-btn <?= $current_page <= 1 ? 'is-disabled' : '' ?>" aria-label="Previous Page">
            &larr; Prev
          </a>

          <!-- Page numbers -->
          <?php
            $start_pg = max(1, $current_page - 2);
            $end_pg   = min($total_pages, $current_page + 2);
            if ($start_pg > 1): ?>
              <a href="<?= $build_url(1) ?>" class="blog-page-btn">1</a>
              <?php if ($start_pg > 2): ?><span style="padding:0 4px;color:var(--blog-muted);">&hellip;</span><?php endif; ?>
            <?php endif; ?>

            <?php for ($p = $start_pg; $p <= $end_pg; $p++): ?>
              <a href="<?= $build_url($p) ?>" class="blog-page-btn <?= $p === $current_page ? 'is-active' : '' ?>">
                <?= $p ?>
              </a>
            <?php endfor; ?>

            <?php if ($end_pg < $total_pages): ?>
              <?php if ($end_pg < $total_pages - 1): ?><span style="padding:0 4px;color:var(--blog-muted);">&hellip;</span><?php endif; ?>
              <a href="<?= $build_url($total_pages) ?>" class="blog-page-btn"><?= $total_pages ?></a>
            <?php endif; ?>

          <!-- Next Page -->
          <a href="<?= $build_url(min($total_pages, $current_page + 1)) ?>" class="blog-page-btn <?= $current_page >= $total_pages ? 'is-disabled' : '' ?>" aria-label="Next Page">
            Next &rarr;
          </a>
        </nav>
      <?php endif; ?>

    <?php else: ?>
      <div class="blog-no-results">
        <h3>No Articles Found</h3>
        <p>We couldn't find any articles matching your search criteria. Try a different keyword or category.</p>
        <a href="<?= url('blog.php') ?>" class="btn btn--primary">View All Articles</a>
      </div>
    <?php endif; ?>

  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
