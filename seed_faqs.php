<?php
/**
 * Seeds the faqs table with page-specific FAQs.
 * Run once: php seed_faqs.php
 */
require __DIR__ . '/includes/db.php';
require __DIR__ . '/config/site.php';
$pdo = db();

// Clear existing FAQs first
$pdo->exec('DELETE FROM faqs');
$pdo->exec('ALTER TABLE faqs AUTO_INCREMENT = 1');

$faqs = [

  // ── GENERAL / HOME (page = 'general') ─────────────────────────────────────
  [
    'question'   => 'What does TechBound do?',
    'answer'     => 'TechBound is a full-service digital marketing agency based in Trivandrum, Kerala. We help businesses grow online through SEO, AI SEO, social media marketing, paid advertising, website development and lead generation.',
    'page'       => 'general',
    'sort_order' => 1,
  ],
  [
    'question'   => 'Where is TechBound located and do you work with clients outside Kerala?',
    'answer'     => 'Our office is in Trivandrum (Thiruvananthapuram), Kerala. We work with clients across India, the GCC region and globally — most of our work is done remotely with regular video check-ins.',
    'page'       => 'general',
    'sort_order' => 2,
  ],
  [
    'question'   => 'How do I get started with TechBound?',
    'answer'     => 'Simply fill in the contact form on our website, call us or send an email. We\'ll schedule a free discovery call to understand your business goals and suggest the right strategy.',
    'page'       => 'general',
    'sort_order' => 3,
  ],
  [
    'question'   => 'What industries do you specialise in?',
    'answer'     => 'We\'ve worked with businesses in e-commerce, healthcare, education, real estate, hospitality, B2B services and more. If your customers search for you online, we can help you reach them.',
    'page'       => 'general',
    'sort_order' => 4,
  ],
  [
    'question'   => 'Do you offer long-term contracts or flexible plans?',
    'answer'     => 'We offer both. Month-to-month retainers for clients who want flexibility, and discounted quarterly or annual plans for businesses that want to commit to a sustained growth strategy.',
    'page'       => 'general',
    'sort_order' => 5,
  ],

  // ── SERVICES ──────────────────────────────────────────────────────────────
  [
    'question'   => 'Which digital marketing services does TechBound offer?',
    'answer'     => 'We offer SEO, AI SEO, Social Media Marketing (SMM), Online Advertising (Google & Meta Ads), Website Development and Lead Generation. All services can be taken individually or as a combined growth package.',
    'page'       => 'services',
    'sort_order' => 1,
  ],
  [
    'question'   => 'Can I hire TechBound for a single service, or do I need a full package?',
    'answer'     => 'You can hire us for any single service. Many clients start with SEO or social media and add more services as their business grows. We\'ll advise you on what makes the most sense for your budget and goals.',
    'page'       => 'services',
    'sort_order' => 2,
  ],
  [
    'question'   => 'How long before I see results from digital marketing?',
    'answer'     => 'Paid advertising can produce leads within days. SEO typically takes 3–6 months to show significant rankings growth, though technical improvements are visible faster. We set realistic timelines in every proposal.',
    'page'       => 'services',
    'sort_order' => 3,
  ],
  [
    'question'   => 'Do you build websites, or only do marketing?',
    'answer'     => 'We do both. Our web development team builds fast, conversion-focused websites — and our marketing teams then drive traffic to them. Having both under one roof means your site and campaigns are always aligned.',
    'page'       => 'services',
    'sort_order' => 4,
  ],
  [
    'question'   => 'What reporting will I receive?',
    'answer'     => 'You\'ll receive monthly performance reports covering key metrics relevant to your service (rankings, traffic, leads, ad spend, conversions). We also hold regular review calls so you\'re always in the loop.',
    'page'       => 'services',
    'sort_order' => 5,
  ],

  // ── SEO ───────────────────────────────────────────────────────────────────
  [
    'question'   => 'What is included in TechBound\'s SEO service?',
    'answer'     => 'Our SEO service covers technical site audits, on-page optimisation, keyword and content strategy, local SEO (Google Business Profile), link building and monthly ranking reports.',
    'page'       => 'seo',
    'sort_order' => 1,
  ],
  [
    'question'   => 'How is AI SEO different from traditional SEO?',
    'answer'     => 'Traditional SEO focuses on ranking in classic Google search results. AI SEO (Generative Engine Optimisation) is about making your brand appear inside AI-generated answers from tools like Google Gemini, ChatGPT, Perplexity and SGE. We optimise for both.',
    'page'       => 'seo',
    'sort_order' => 2,
  ],
  [
    'question'   => 'Do you offer local SEO for businesses in Trivandrum and Kerala?',
    'answer'     => 'Yes. Local SEO is one of our specialisms. We optimise Google Business Profiles, build local citations and create content targeting Trivandrum, Kerala and GCC searches to drive foot traffic and local leads.',
    'page'       => 'seo',
    'sort_order' => 3,
  ],
  [
    'question'   => 'How much does SEO cost?',
    'answer'     => 'SEO pricing depends on the size of your website, your industry competition and the scope of work needed. We offer transparent monthly retainer plans starting from a scope agreed in a free audit call — no hidden fees.',
    'page'       => 'seo',
    'sort_order' => 4,
  ],
  [
    'question'   => 'Can you recover a website hit by a Google penalty?',
    'answer'     => 'Yes. We handle manual and algorithmic penalty recovery, including link disavow, thin-content cleanup and E-E-A-T improvements. We\'ll start with a full audit to identify the cause before proposing a recovery plan.',
    'page'       => 'seo',
    'sort_order' => 5,
  ],

  // ── ABOUT ─────────────────────────────────────────────────────────────────
  [
    'question'   => 'How long has TechBound been in business?',
    'answer'     => 'TechBound Innovations was founded in Trivandrum and has been helping businesses grow digitally for over 12 years, working with brands across Kerala, India and the GCC.',
    'page'       => 'about',
    'sort_order' => 1,
  ],
  [
    'question'   => 'What makes TechBound different from other digital marketing agencies?',
    'answer'     => 'We combine deep local market knowledge with global digital strategy. Our team stays at the forefront of AI-driven search changes, and we measure success by business outcomes — leads, revenue and growth — not just vanity metrics.',
    'page'       => 'about',
    'sort_order' => 2,
  ],
  [
    'question'   => 'How big is the TechBound team?',
    'answer'     => 'We have a dedicated in-house team of SEO strategists, content writers, social media managers, paid ads specialists, web developers and designers, all working from our Trivandrum office.',
    'page'       => 'about',
    'sort_order' => 3,
  ],
  [
    'question'   => 'Does TechBound work with startups or only established businesses?',
    'answer'     => 'Both. We love helping startups build their digital presence from scratch and helping established brands scale further. Our strategies are tailored to your stage of growth and budget.',
    'page'       => 'about',
    'sort_order' => 4,
  ],

  // ── CONTACT ───────────────────────────────────────────────────────────────
  [
    'question'   => 'How quickly will TechBound respond to my enquiry?',
    'answer'     => 'We respond to all enquiries within one working day. For urgent requests you can also call us directly at +91 8606497677 during business hours (Mon–Sat, 9 AM–6:30 PM IST).',
    'page'       => 'contact',
    'sort_order' => 1,
  ],
  [
    'question'   => 'What information should I include in my message?',
    'answer'     => 'The more you share, the better. Tell us your business name, website URL, what you\'re trying to achieve (more leads, better rankings, a new website, etc.) and your approximate budget. This helps us prepare relevant ideas for our first call.',
    'page'       => 'contact',
    'sort_order' => 2,
  ],
  [
    'question'   => 'Is the initial consultation free?',
    'answer'     => 'Yes, completely. We offer a free discovery call where we listen to your goals, review your current digital presence and outline what a strategy could look like — with no obligation to sign up.',
    'page'       => 'contact',
    'sort_order' => 3,
  ],
  [
    'question'   => 'Can I visit your office in Trivandrum?',
    'answer'     => 'Absolutely. Our office is at 6th Floor, Karimpanal Statue Avenue, Opposite Secretariat, Thiruvananthapuram 695001. We welcome in-person meetings — just drop us a message to book a slot.',
    'page'       => 'contact',
    'sort_order' => 4,
  ],
];

$stmt = $pdo->prepare(
    'INSERT INTO faqs (question, answer, sort_order, active) VALUES (?, ?, ?, 1)'
);

// Add a 'page' column if not exists — but actually the schema has no page column,
// so we store page context in sort_order ranges per page (or just insert all and filter by page slug via a page column).
// Since there's no 'page' column, we'll add it first.

// Check if 'page' column exists
$cols = $pdo->query("SHOW COLUMNS FROM faqs")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array('page', $cols)) {
    $pdo->exec("ALTER TABLE faqs ADD COLUMN page VARCHAR(60) NOT NULL DEFAULT 'general' AFTER active");
    echo "Added 'page' column to faqs table.\n";
}

$stmtPage = $pdo->prepare(
    'INSERT INTO faqs (question, answer, sort_order, active, page) VALUES (?, ?, ?, 1, ?)'
);

$count = 0;
foreach ($faqs as $faq) {
    $stmtPage->execute([$faq['question'], $faq['answer'], $faq['sort_order'], $faq['page']]);
    $count++;
}

echo "Seeded $count FAQs successfully.\n";
