<?php
/**
 * Reusable FAQ section partial.
 *
 * Usage — include just before footer.php on any page:
 *   $faq_page  = 'general';          // matches the `page` column in the faqs table
 *   $faq_title = 'Frequently Asked Questions';  // optional override
 *   require __DIR__ . '/includes/faq-section.php';
 *
 * Renders nothing if no active FAQs exist for that page.
 */

$faq_page  = $faq_page  ?? 'general';
$faq_title = $faq_title ?? 'Frequently Asked Questions';

// Lazy-load DB if not already open
if (!function_exists('db')) {
    require_once __DIR__ . '/../includes/db.php';
}

$_faqs = [];
try {
    $_faq_stmt = db()->prepare(
        "SELECT question, answer FROM faqs WHERE active = 1 AND page = ? ORDER BY sort_order ASC, id ASC"
    );
    $_faq_stmt->execute([$faq_page]);
    $_faqs = $_faq_stmt->fetchAll();
} catch (Throwable $e) {
    $_faqs = [];
}

// Fallback FAQs if DB is unavailable or page has no seeded records
if (empty($_faqs)) {
    $fallback_faqs = [
        'contact' => [
            ['question' => 'How quickly will TechBound respond to my enquiry?', 'answer' => 'We respond to all enquiries within one working day. For urgent requests you can also call us directly at +91 8606497677 during business hours (Mon–Sat, 9 AM–6:30 PM IST).'],
            ['question' => 'What information should I include in my message?', 'answer' => "The more you share, the better. Tell us your business name, website URL, what you're trying to achieve (more leads, better rankings, a new website, etc.) and your approximate budget."],
            ['question' => 'Is the initial consultation free?', 'answer' => 'Yes, completely. We offer a free discovery call where we listen to your goals, review your current digital presence and outline what a strategy could look like — with no obligation to sign up.'],
            ['question' => 'Can I visit your office in Trivandrum?', 'answer' => 'Absolutely. Our office is at 6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Thiruvananthapuram 695001. We welcome in-person meetings — just drop us a message to book a slot.']
        ],
        'about' => [
            ['question' => 'How long has TechBound been in business?', 'answer' => 'TechBound Innovations was founded in Trivandrum and has been helping businesses grow digitally for over 15 years. Today we work from offices in Trivandrum and Kochi, serving brands across Kerala, India and the GCC.'],
            ['question' => 'What makes TechBound different from other digital marketing agencies?', 'answer' => 'We combine deep local market knowledge with global digital strategy. Our team stays at the forefront of AI-driven search changes, and we measure success by business outcomes — leads, revenue and growth.'],
            ['question' => 'How big is the TechBound team?', 'answer' => 'We have a dedicated in-house team of SEO strategists, content writers, social media managers, paid ads specialists, web developers and designers, all working from our Trivandrum office.'],
            ['question' => 'Does TechBound work with startups or only established businesses?', 'answer' => 'Both. We love helping startups build their digital presence from scratch and helping established brands scale further. Our strategies are tailored to your stage of growth and budget.']
        ],
        'services' => [
            ['question' => 'Which digital marketing services does TechBound offer?', 'answer' => 'We offer SEO, AI SEO, Social Media Marketing (SMM), Online Advertising (Google & Meta Ads), Website Development and Lead Generation. All services can be taken individually or as a combined growth package.'],
            ['question' => 'Can I hire TechBound for a single service, or do I need a full package?', 'answer' => 'You can hire us for any single service. Many clients start with SEO or social media and add more services as their business grows.'],
            ['question' => 'How long before I see results from digital marketing?', 'answer' => 'Paid advertising can produce leads within days. SEO typically takes 3–6 months to show significant rankings growth, though technical improvements are visible faster.']
        ]
    ];
    $_faqs = $fallback_faqs[$faq_page] ?? [];
}

if (empty($_faqs)) return; // nothing to render
?>

<!-- ===== FAQ SECTION ===== -->
<section class="faq" id="faq" data-nav="light">
  <div class="faq__inner">
    <h2 class="faq__title"><?= htmlspecialchars($faq_title, ENT_QUOTES, 'UTF-8') ?></h2>

    <div class="faq__list">
      <?php foreach ($_faqs as $_i => $_faq):
        $_q = trim($_faq['question']);
        if (!preg_match('/^\d+\.\s/', $_q)) {
          $_q = ($_i + 1) . '. ' . $_q;
        }
        $_is_open = ($_i === 0);
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
            <?php
              $_ansHtml = htmlspecialchars($_faq['answer'], ENT_QUOTES, 'UTF-8');
              $_kochiHref = htmlspecialchars(url('digital-marketing-agency-in-kochi.php'), ENT_QUOTES, 'UTF-8');
              $_ansHtml = preg_replace('/\bKochi\b/', '<a href="' . $_kochiHref . '" style="color:var(--brand);text-decoration:underline;text-underline-offset:3px;">Kochi</a>', $_ansHtml);
            ?>
            <p><?= $_ansHtml ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
