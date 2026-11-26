<?php
/**
 * Reusable Dynamic FAQ section partial.
 *
 * Usage — include just before footer.php on any page:
 *   $faq_page  = 'home';                         // matches the `page` column in the faqs table
 *   $faq_title = 'Frequently Asked Questions';   // optional override
 *   require __DIR__ . '/includes/faq-section.php';
 *
 * Behavior:
 * - Loads active FAQs for $faq_page from MySQL `faqs` table.
 * - If DB is reachable and 0 active FAQs exist for this page, renders NOTHING
 *   (completely removes the FAQ section from the page).
 * - If DB is unreachable, falls back to the auto-synced `data/faqs_cache.php`.
 */

$faq_page  = $faq_page  ?? 'home';
$faq_title = $faq_title ?? 'Frequently Asked Questions';

if (!function_exists('db')) {
    require_once __DIR__ . '/../includes/db.php';
}

$_faqs  = [];
$_db_ok = false;

try {
    $_faq_stmt = db()->prepare(
        "SELECT question, answer FROM faqs WHERE active = 1 AND page = ? ORDER BY sort_order ASC, id ASC"
    );
    $_faq_stmt->execute([$faq_page]);
    $_faqs  = $_faq_stmt->fetchAll();
    $_db_ok = true;
} catch (Throwable $e) {
    $_db_ok = false;
    $_faqs  = [];
}

// Fallback ONLY if database is unreachable — never override an intentionally emptied page!
if (!$_db_ok) {
    $_cacheFile = __DIR__ . '/../data/faqs_cache.php';
    if (is_file($_cacheFile)) {
        $_allCached = require $_cacheFile;
        if (is_array($_allCached)) {
            foreach ($_allCached as $_row) {
                if ((int)($_row['active'] ?? 0) === 1 && ($_row['page'] ?? '') === $faq_page) {
                    $_faqs[] = $_row;
                }
            }
        }
    }
}

// If there are no active FAQs for this page, do not render the FAQ section at all.
if (empty($_faqs)) {
    return;
}
?>

<!-- ===== FAQ SECTION ===== -->
<section class="faq" id="faq" data-nav="light">
  <div class="faq__inner">
    <h2 class="faq__title"><?= htmlspecialchars($faq_title, ENT_QUOTES, 'UTF-8') ?></h2>

    <div class="faq__list">
      <?php foreach ($_faqs as $_i => $_faq):
        $_q = trim((string)($_faq['question'] ?? ''));
        if (!preg_match('/^\d+\.\s/', $_q)) {
          $_q = ($_i + 1) . '. ' . $_q;
        }
        $_is_open = ($_i === 0);
        $_ans_raw = trim((string)($_faq['answer'] ?? ''));
      ?>
      <div class="faq__item<?= $_is_open ? ' is-open' : '' ?>">
        <h3>
          <button
            class="faq__question"
            type="button"
            aria-expanded="<?= $_is_open ? 'true' : 'false' ?>"
            aria-controls="faq-<?= htmlspecialchars($faq_page, ENT_QUOTES, 'UTF-8') ?>-<?= $_i + 1 ?>"
          >
            <?= htmlspecialchars($_q, ENT_QUOTES, 'UTF-8') ?>
          </button>
        </h3>
        <div
          class="faq__answer"
          id="faq-<?= htmlspecialchars($faq_page, ENT_QUOTES, 'UTF-8') ?>-<?= $_i + 1 ?>"
        >
          <div class="faq__answer-inner">
            <p><?= nl2br(htmlspecialchars($_ans_raw, ENT_QUOTES, 'UTF-8')) ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
