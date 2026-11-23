<?php
require_once __DIR__ . '/config/site.php';

$slug = trim($_GET['slug'] ?? '');
$id   = (int)($_GET['id'] ?? 0);

// Helper to find a post by slug or id (with DB and JSON fallback)
function get_single_post(string $slug, int $id): ?array {
    $post = null;
    try {
        require_once __DIR__ . '/includes/db.php';
        $pdo = db();
        if ($slug !== '') {
            $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ? AND active = 1 LIMIT 1");
            $stmt->execute([$slug]);
            $post = $stmt->fetch();
        }
        if (!$post && $id > 0) {
            $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ? AND active = 1 LIMIT 1");
            $stmt->execute([$id]);
            $post = $stmt->fetch();
        }
    } catch (Throwable $e) {
        $post = null;
    }

    // Fallback 1: Precompiled PHP full archive (100% reliable on any host)
    if (!$post) {
        $phpPath = __DIR__ . '/data/blogs_full.php';
        if (file_exists($phpPath)) {
            $fullData = require $phpPath;
            if (is_array($fullData)) {
                foreach ($fullData as $p) {
                    if (($p['active'] ?? 1) == 1) {
                        if ($slug !== '' && ($p['slug'] ?? '') === $slug) {
                            $post = $p;
                            break;
                        }
                        if ($id > 0 && ($p['id'] ?? 0) === $id) {
                            $post = $p;
                            break;
                        }
                    }
                }
            }
        }
    }

    // Fallback 2: Local JSON file
    if (!$post) {
        foreach ([__DIR__ . '/techbound_blogs.json', __DIR__ . '/data/techbound_blogs.json'] as $jsonPath) {
            if (file_exists($jsonPath)) {
                $data = json_decode(file_get_contents($jsonPath), true);
                if (is_array($data)) {
                    foreach ($data as $p) {
                        if (($p['active'] ?? 1) == 1) {
                            if ($slug !== '' && ($p['slug'] ?? '') === $slug) {
                                $post = $p;
                                break;
                            }
                            if ($id > 0 && ($p['id'] ?? 0) === $id) {
                                $post = $p;
                                break;
                            }
                        }
                    }
                }
                if ($post) break;
            }
        }
    }

    return $post ?: null;
}

// Helper to get related posts
function get_related_posts(string $category, int $exclude_id, int $limit = 3): array {
    $related = [];
    try {
        require_once __DIR__ . '/includes/db.php';
        $pdo = db();
        $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE active = 1 AND id != ? AND category = ? ORDER BY published_at DESC LIMIT ?");
        $stmt->bindValue(1, $exclude_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $category, PDO::PARAM_STR);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $related = $stmt->fetchAll();
        
        // If not enough in category, fetch recent posts
        if (count($related) < $limit) {
            $needed = $limit - count($related);
            $existing_ids = array_merge([$exclude_id], array_column($related, 'id'));
            $inClause = implode(',', array_fill(0, count($existing_ids), '?'));
            $stmt2 = $pdo->prepare("SELECT * FROM blog_posts WHERE active = 1 AND id NOT IN ($inClause) ORDER BY published_at DESC LIMIT $needed");
            $stmt2->execute($existing_ids);
            $related = array_merge($related, $stmt2->fetchAll());
        }
    } catch (Throwable $e) {
        $related = [];
    }

    if (empty($related)) {
        $candidates = [];
        $phpPath = __DIR__ . '/data/blogs_index.php';
        if (file_exists($phpPath)) {
            $candidates = require $phpPath;
        } elseif (file_exists(__DIR__ . '/techbound_blogs.json')) {
            $candidates = json_decode(file_get_contents(__DIR__ . '/techbound_blogs.json'), true) ?: [];
        }

        if (is_array($candidates) && !empty($candidates)) {
            $valid = array_filter($candidates, fn($p) => ($p['id'] ?? 0) !== $exclude_id && ($p['active'] ?? 1) == 1);
            $same_cat = array_filter($valid, fn($p) => ($p['category'] ?? '') === $category);
            $related = array_slice($same_cat, 0, $limit);
            if (count($related) < $limit) {
                $other = array_filter($valid, fn($p) => ($p['category'] ?? '') !== $category);
                $related = array_merge($related, array_slice($other, 0, $limit - count($related)));
            }
        }
    }

    return $related;
}

$post = get_single_post($slug, $id);

// 404 if post not found
if (!$post) {
    http_response_code(404);
    $page_title   = 'Article Not Found | TechBound';
    $page_desc    = 'The blog article you are looking for may have been moved or renamed. Explore our latest guides and digital marketing insights on the TechBound blog.';
    $page_styles  = ['css/blog.css'];
    $show_faq_btn = false;
    include __DIR__ . '/includes/header.php';
    ?>
    <section class="hero hero--inner" style="background-image: url('<?= asset('assets/mega-blog.avif') ?>');">
      <div class="hero__overlay"></div>
      <div class="hero__content">
        <div class="hero__body">
          <div class="hero__text">
            <h1 class="hero__title">Article Not Found</h1>
            <p class="hero__desc">The blog article you are looking for may have been moved or renamed.</p>
          </div>
          <div class="hero__buttons">
            <a href="<?= url('blog.php') ?>" class="btn btn--primary btn--arrow">Back to All Articles</a>
          </div>
        </div>
      </div>
    </section>
    <?php
    include __DIR__ . '/includes/footer.php';
    exit;
}

// Calculate reading time
$word_count = str_word_count(strip_tags($post['body'] ?? ''));
$read_time  = max(1, (int)ceil($word_count / 200));

// Setup page meta
$post_title   = trim($post['title'] ?? 'Article');
$raw_desc     = trim($post['excerpt'] ?? '');
if ($raw_desc === '') {
    $raw_desc = trim(preg_replace('/\s+/', ' ', strip_tags($post['body'] ?? '')));
    $raw_desc = mb_substr($raw_desc, 0, 160);
}
$page_title   = $post_title . ' | TechBound Blog';
$page_desc    = $raw_desc;
$header_light = false;
$page_styles  = ['css/blog.css'];
$show_faq_btn = false;

$related_posts = get_related_posts($post['category'] ?? 'Digital Marketing', (int)$post['id'], 4);

// Current canonical URL for social sharing
$share_url   = url('blog-post.php?slug=' . urlencode($post['slug']));
$share_title = urlencode($post['title']);

include __DIR__ . '/includes/header.php';
?>

<!-- ===== BLOG POST HERO (Consistent across all blogs) ===== -->
<section class="hero hero--inner post-hero" style="background-image: url('<?= asset('assets/mega-blog.avif') ?>');" data-nav="dark">
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <div class="hero__tagline-wrap">
      <nav class="hero__crumbs" aria-label="Breadcrumb">
        <a href="<?= url('index.php') ?>">Home</a><span>/</span>
        <a href="<?= url('blog.php') ?>">Blog</a><span>/</span>
        <span class="is-current"><?= htmlspecialchars($post['category'] ?? 'Digital Marketing') ?></span>
      </nav>
      <div class="hero__line"></div>
    </div>

    <div class="hero__body">
      <div class="hero__text">
        <span class="blog-cat-pill blog-cat-pill--hero"><?= htmlspecialchars($post['category'] ?? 'Digital Marketing') ?></span>
        <h1 class="hero__title post-hero__title"><?= htmlspecialchars($post['title']) ?></h1>
      </div>
    </div>
  </div>
</section>

<article class="post-article" data-nav="light">
  <!-- Article Meta -->
  <header class="post-header">
    <div class="post-meta-bar">
      <div class="blog-author">
        <span class="blog-author-avatar" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </span>
        <div class="blog-author-info">
          <span class="blog-author-name"><?= htmlspecialchars($post['author'] ?? 'TechBound Team') ?></span>
          <span class="blog-author-role"><?= htmlspecialchars(!empty($post['author_designation']) ? $post['author_designation'] : 'Digital Marketing Specialist') ?></span>
        </div>
      </div>
      <span>·</span>
      <time datetime="<?= htmlspecialchars($post['published_at']) ?>"><?= date('F j, Y', strtotime($post['published_at'])) ?></time>
      <span>·</span>
      <span>⏱ <?= $read_time ?> min read</span>
    </div>
  </header>

  <!-- Featured Image (Always rendered with real image or category placeholder) -->
  <div class="post-featured-media">
    <div class="post-featured-media__wrap">
      <img src="<?= htmlspecialchars(blog_image_url($post['image'] ?? '', $post['category'] ?? null)) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="eager" onerror="this.onerror=null; this.src='<?= asset(blog_placeholder($post['category'] ?? null)) ?>';">
    </div>
  </div>

  <!-- Article Body Content -->
  <div class="post-content-container">
    <div class="post-body">
      <?= $post['body'] ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
      var fallbackImg = '<?= asset(blog_placeholder($post['category'] ?? null)) ?>';
      document.querySelectorAll('.post-body img').forEach(function(img) {
        img.addEventListener('error', function() {
          this.onerror = null;
          this.src = fallbackImg;
          this.style.borderRadius = '12px';
          this.style.boxShadow = '0 8px 24px rgba(0,0,0,0.08)';
        });
      });
    });
    </script>

    <!-- Author Byline Card -->
    <div style="margin-top:40px; margin-bottom:28px; padding:22px 26px; border-radius:16px; background:#f8fafc; border:1px solid #e2e8f0; display:flex; align-items:center; gap:18px;">
      <div style="width:52px; height:52px; border-radius:50%; background:var(--brand); color:#fff; display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:700; flex-shrink:0;">
        <?= strtoupper(substr($post['author'] ?? 'T', 0, 1)) ?>
      </div>
      <div>
        <h4 style="margin:0 0 4px; font-size:16px; font-weight:700; color:#0a1220;"><?= htmlspecialchars($post['author'] ?? 'TechBound Team') ?></h4>
        <p style="margin:0; font-size:13.5px; color:#64748b; font-weight:500;"><?= htmlspecialchars($post['author_designation'] ?? 'Digital Growth Specialist') ?> · TechBound Innovations</p>
      </div>
    </div>

    <!-- Share & Footer Bar -->
    <div class="post-share-bar">
      <div style="font-family:var(--font-heading);font-weight:700;font-size:15px;color:#0a1220;">
        Share this article:
      </div>
      <div class="post-share-links">
        <!-- Twitter/X -->
        <a href="https://twitter.com/intent/tweet?text=<?= $share_title ?>&url=<?= urlencode($share_url) ?>" target="_blank" rel="noopener noreferrer" class="post-share-btn" title="Share on X (Twitter)" aria-label="Share on X">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
        </a>
        <!-- LinkedIn -->
        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($share_url) ?>" target="_blank" rel="noopener noreferrer" class="post-share-btn" title="Share on LinkedIn" aria-label="Share on LinkedIn">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <!-- WhatsApp -->
        <a href="https://api.whatsapp.com/send?text=<?= $share_title ?>%20<?= urlencode($share_url) ?>" target="_blank" rel="noopener noreferrer" class="post-share-btn" title="Share on WhatsApp" aria-label="Share on WhatsApp">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 2C6.495 2 2 6.495 2 12.031c0 1.97.57 3.81 1.558 5.372L2 22l4.757-1.52A9.97 9.97 0 0 0 12.031 22c5.536 0 10.031-4.495 10.031-10.031S17.567 2 12.031 2zm5.727 14.182c-.244.686-1.218 1.258-1.745 1.341-.527.083-1.196.118-3.473-.822-2.434-1.006-3.992-3.486-4.113-3.649-.122-.162-.977-1.302-.977-2.484 0-1.182.61-1.763.829-2.002.218-.24.476-.3.635-.3.159 0 .318.002.456.009.146.008.342-.055.534.407.2.482.684 1.666.744 1.787.06.122.1.264.02.424-.08.16-.12.26-.24.4-.12.14-.251.312-.358.42-.12.12-.246.25-.106.49.14.24.622 1.026 1.336 1.662.918.817 1.691 1.07 1.931 1.19.24.12.38.1.52-.06.14-.16.6-.7.76-.94.16-.24.32-.2.54-.12.22.08 1.396.658 1.636.778.24.12.4.18.46.28.06.1.06.58-.184 1.266z"/></svg>
        </a>
        <!-- Back to blog link -->
        <a href="<?= url('blog.php') ?>" class="btn btn--outline" style="padding:8px 18px;font-size:13.5px;color:#0a1220;border-color:#cbd5e1;">
          &larr; All Articles
        </a>
      </div>
    </div>
  </div>
</article>

<!-- Related Articles Section -->
<?php if (!empty($related_posts)): ?>
<section class="related-posts-section">
  <div class="related-posts-inner">
    <div class="related-posts-header">
      <h2 class="related-posts-title">Related Articles</h2>
      <a href="<?= url('blog.php?cat=' . urlencode($post['category'] ?? 'Digital Marketing')) ?>" style="font-family:var(--font-heading);font-weight:700;color:var(--brand);display:inline-flex;align-items:center;gap:6px;">
        More in <?= htmlspecialchars($post['category'] ?? 'Digital Marketing') ?> &rarr;
      </a>
    </div>

    <div class="blog-grid" style="margin-bottom:0;">
      <?php foreach ($related_posts as $rel): ?>
        <article class="blog-card">
          <a href="<?= url('blog-post.php?slug=' . urlencode($rel['slug'])) ?>" class="blog-card__media">
            <img src="<?= htmlspecialchars(blog_image_url($rel['image'] ?? '', $rel['category'] ?? null)) ?>" alt="<?= htmlspecialchars($rel['title']) ?>" loading="lazy" onerror="this.onerror=null; this.src='<?= asset(blog_placeholder($rel['category'] ?? null)) ?>';">
          </a>
          <div class="blog-card__body">
            <div class="blog-card__meta">
              <span class="blog-cat-pill"><?= htmlspecialchars($rel['category'] ?? 'Digital Marketing') ?></span>
              <span style="font-size:12.5px;color:var(--blog-muted);"><?= date('M j, Y', strtotime($rel['published_at'])) ?></span>
            </div>
            <h3 class="blog-card__title">
              <a href="<?= url('blog-post.php?slug=' . urlencode($rel['slug'])) ?>"><?= htmlspecialchars($rel['title']) ?></a>
            </h3>
            <p class="blog-card__excerpt"><?= htmlspecialchars($rel['excerpt']) ?></p>
            <div class="blog-card__footer">
              <div class="blog-author blog-author--compact">
                <span class="blog-author-avatar" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
                <div class="blog-author-info">
                  <span class="blog-author-name"><?= htmlspecialchars($rel['author'] ?? 'TechBound Team') ?></span>
                  <span class="blog-author-role"><?= htmlspecialchars(!empty($rel['author_designation']) ? $rel['author_designation'] : 'Digital Marketing Specialist') ?></span>
                </div>
              </div>
              <a href="<?= url('blog-post.php?slug=' . urlencode($rel['slug'])) ?>" class="blog-read-link">
                Read
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
