<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();
$user = admin_current();

// CSRF Token
if (empty($_SESSION['_csrf'])) {
    $_SESSION['_csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['_csrf'];

$id = (int)($_GET['id'] ?? 0);
$post = null;
$is_new = ($id === 0);

if (!$is_new) {
    if ($pdo) {
        $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE id = ?');
        $stmt->execute([$id]);
        $post = $stmt->fetch();
    } else {
        $fullPath = __DIR__ . '/../../data/blogs_full.php';
        if (is_file($fullPath)) {
            $all = require $fullPath;
            foreach ($all as $item) {
                if ((int)($item['id'] ?? 0) === $id) {
                    $post = $item;
                    break;
                }
            }
        }
    }
    if (!$post) {
        header('Location: ' . admin_url('resources/blog_posts.php?flash=' . urlencode('error:Article not found.')));
        exit;
    }
}

// Ensure meta_title and meta_description columns exist on blog_posts
function ensure_blog_meta_columns(PDO $pdo): void {
    try {
        $cols = $pdo->query("SHOW COLUMNS FROM blog_posts")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array('meta_title', $cols, true)) {
            $pdo->exec("ALTER TABLE blog_posts ADD COLUMN meta_title VARCHAR(255) NOT NULL DEFAULT '' AFTER title");
        }
        if (!in_array('meta_description', $cols, true)) {
            $pdo->exec("ALTER TABLE blog_posts ADD COLUMN meta_description TEXT NULL AFTER meta_title");
        }
        if (!in_array('image_alt_description', $cols, true)) {
            $pdo->exec("ALTER TABLE blog_posts ADD COLUMN image_alt_description LONGTEXT NULL AFTER image");
        }
    } catch (Throwable $e) {
        // Skip silently if ALTER is restricted
    }
}

if ($pdo) {
    ensure_blog_meta_columns($pdo);
}

// Helper to keep techbound_blogs.json and data/blogs_*.php synchronized with MySQL
function sync_blogs_to_json(PDO $pdo): void {
    try {
        $all = $pdo->query('SELECT * FROM blog_posts ORDER BY published_at DESC, id DESC')->fetchAll();
        $jsonPath = __DIR__ . '/../../techbound_blogs.json';
        file_put_contents($jsonPath, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

        // Keep precompiled fallback arrays synced
        $indexPath = __DIR__ . '/../../data/blogs_index.php';
        if (is_dir(dirname($indexPath))) {
            $light = array_map(function($p) {
                unset($p['body']);
                return $p;
            }, $all);
            file_put_contents($indexPath, "<?php\nreturn " . var_export($light, true) . ";\n");
        }

        $fullPath = __DIR__ . '/../../data/blogs_full.php';
        if (is_dir(dirname($fullPath))) {
            file_put_contents($fullPath, "<?php\nreturn " . var_export($all, true) . ";\n");
        }
    } catch (Throwable $e) {
        // Continue even if sync has file permission restriction
    }
}

$flash = null;

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($csrf, (string)($_POST['_csrf'] ?? ''))) {
        $flash = 'error:Security token expired. Please resubmit the form.';
    } else {
        $title              = trim($_POST['title'] ?? '');
        $slug               = trim($_POST['slug'] ?? '');
        $category           = trim($_POST['category'] ?? 'Digital Marketing');
        $custom_category    = trim($_POST['custom_category'] ?? '');
        if ($category === '__custom__' && $custom_category !== '') {
            $category = $custom_category;
        }
        $tags               = trim($_POST['tags'] ?? '');
        $author             = trim($_POST['author'] ?? ($user['name'] ?? 'TechBound Team'));
        $author_designation = trim($_POST['author_designation'] ?? 'Digital Growth Specialist');
        $excerpt            = trim($_POST['excerpt'] ?? '');
        $meta_title         = trim($_POST['meta_title'] ?? '');
        $meta_description   = trim($_POST['meta_description'] ?? '');
        $body               = trim($_POST['body'] ?? '');
        $image                 = trim($_POST['image'] ?? '');
        $image_alt_description = trim($_POST['image_alt_description'] ?? '');
        $published_at          = trim($_POST['published_at'] ?? '');
        $active             = isset($_POST['active']) ? (int)$_POST['active'] : 1;
        $save_action        = $_POST['save_action'] ?? 'save_close'; // save_close or save_continue

        if (!$pdo) {
            $flash = 'error:Cannot save article: MySQL database is disconnected. Please configure Render DB environment variables.';
        } elseif ($title === '') {
            $flash = 'error:Article title is required.';
        } else {
            // Slugify if empty
            if ($slug === '') {
                $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-'));
            } else {
                $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $slug), '-'));
            }

            // Ensure unique slug
            $stmtSlug = $pdo->prepare('SELECT id FROM blog_posts WHERE slug = ? AND id != ?');
            $stmtSlug->execute([$slug, $id]);
            if ($stmtSlug->fetch()) {
                $slug .= '-' . time();
            }

            // Publish date default
            if ($published_at === '') {
                $published_at = date('Y-m-d H:i:s');
            } else {
                $published_at = date('Y-m-d H:i:s', strtotime($published_at));
            }

            // Auto-populate Meta Title & Meta Description if left blank
            if ($meta_title === '') {
                $meta_title = $title . ' | TechBound';
            }
            if ($meta_description === '') {
                $sourceDesc = $excerpt !== '' ? $excerpt : trim(preg_replace('/\s+/', ' ', strip_tags($body)));
                $meta_description = mb_substr($sourceDesc, 0, 160);
            }

            // Fallback image if empty
            if ($image === '') {
                $image = blog_placeholder($category);
            }

            if ($id > 0) {
                // Update
                $stmtUp = $pdo->prepare('UPDATE blog_posts SET title=?, meta_title=?, meta_description=?, slug=?, category=?, tags=?, author=?, author_designation=?, excerpt=?, body=?, image=?, image_alt_description=?, published_at=?, active=? WHERE id=?');
                $stmtUp->execute([
                    $title,
                    $meta_title,
                    $meta_description,
                    $slug,
                    $category ?: 'Digital Marketing',
                    $tags,
                    $author ?: 'TechBound Team',
                    $author_designation ?: 'Digital Growth Specialist',
                    $excerpt,
                    $body,
                    $image,
                    $image_alt_description,
                    $published_at,
                    $active,
                    $id
                ]);
                sync_blogs_to_json($pdo);
                $msg = 'success:Article "' . $title . '" updated successfully.';
                if ($save_action === 'save_continue') {
                    header('Location: ' . admin_url('resources/blog_editor.php?id=' . $id . '&flash=' . urlencode($msg)));
                    exit;
                }
                header('Location: ' . admin_url('resources/blog_posts.php?flash=' . urlencode($msg)));
                exit;
            } else {
                // Insert
                $stmtIn = $pdo->prepare('INSERT INTO blog_posts (title, meta_title, meta_description, slug, category, tags, author, author_designation, excerpt, body, image, image_alt_description, published_at, active) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $stmtIn->execute([
                    $title,
                    $meta_title,
                    $meta_description,
                    $slug,
                    $category ?: 'Digital Marketing',
                    $tags,
                    $author ?: 'TechBound Team',
                    $author_designation ?: 'Digital Growth Specialist',
                    $excerpt,
                    $body,
                    $image,
                    $image_alt_description,
                    $published_at,
                    $active
                ]);
                $newId = (int)$pdo->lastInsertId();
                sync_blogs_to_json($pdo);
                $msg = 'success:Article "' . $title . '" created successfully.';
                if ($save_action === 'save_continue') {
                    header('Location: ' . admin_url('resources/blog_editor.php?id=' . $newId . '&flash=' . urlencode($msg)));
                    exit;
                }
                header('Location: ' . admin_url('resources/blog_posts.php?flash=' . urlencode($msg)));
                exit;
            }
        }
    }
}

$flash = $flash ?? (string)($_GET['flash'] ?? '');
[$flash_type, $flash_msg] = $flash ? array_pad(explode(':', $flash, 2), 2, '') : ['', ''];

// Default form values
$form_title              = $post['title'] ?? '';
$form_meta_title         = $post['meta_title'] ?? '';
$form_meta_description   = $post['meta_description'] ?? '';
$form_slug               = $post['slug'] ?? '';
$form_category           = $post['category'] ?? 'Digital Marketing';
$form_tags               = $post['tags'] ?? '';
$form_author             = $post['author'] ?? ($user['name'] ?? 'TechBound Team');
$form_author_designation = $post['author_designation'] ?? 'Senior Digital Strategist';
$form_excerpt            = $post['excerpt'] ?? '';
$form_body               = $post['body'] ?? '';
$form_image                 = $post['image'] ?? 'assets/placeholders/blog-digital-marketing.svg';
$form_image_alt_description = $post['image_alt_description'] ?? '';
$form_published_at          = !empty($post['published_at']) ? date('Y-m-d\TH:i', strtotime($post['published_at'])) : date('Y-m-d\TH:i');
$form_active             = isset($post['active']) ? (int)$post['active'] : 1;

// Standard Top Categories
$common_categories = [
    'AI & Emerging Tech',
    'Search Engine Optimization',
    'Digital Marketing',
    'Social Media Marketing',
    'Paid Advertising',
    'Web Development',
    'Lead Generation',
    'Branding & Strategy'
];

$page_title = $is_new ? 'New Blog Article' : ('Edit: ' . mb_strimwidth($form_title, 0, 35, '...'));
require __DIR__ . '/../_header.php';
?>

<link rel="stylesheet" href="<?= asset('css/blog.css') ?>">

<div class="flex flex-col w-full pb-16">

    <!-- Top Sticky Header Navigation -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="<?= e(admin_url('resources/blog_posts.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Blog Posts</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold"><?= $is_new ? 'Create Article' : 'Edit Article' ?></span>
            </nav>
            <div class="flex items-center gap-3">
                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight font-bold">
                    <?= $is_new ? 'New Blog Article' : 'Edit Article' ?>
                </h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?= $form_active ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
                    <?= $form_active ? '● Published' : '○ Draft' ?>
                </span>
            </div>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Fill in the author details, article body, featured banner, and SEO settings below.
            </p>
        </div>

        <!-- Header Actions -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?= e(admin_url('resources/blog_posts.php')) ?>" class="h-10 px-4 rounded-lg bg-surface-container text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                <span>All Articles</span>
            </a>
            <?php if (!$is_new && !empty($form_slug)): ?>
            <a href="<?= e(url('blog-post.php?slug=' . urlencode($form_slug))) ?>" target="_blank" class="h-10 px-4 rounded-lg bg-surface-container-high text-primary font-label-lg text-label-lg hover:bg-primary/10 transition-colors flex items-center gap-1.5" title="View live article on public website">
                <span class="material-symbols-outlined text-[18px]">visibility</span>
                <span>View on Site</span>
            </a>
            <?php endif; ?>
            <button type="button" onclick="document.getElementById('save_action').value='save_continue'; document.getElementById('blogPostForm').submit();" class="h-10 px-4 rounded-lg bg-surface-container-highest text-primary font-label-lg text-label-lg hover:bg-surface-container-high active:scale-95 transition-all flex items-center gap-1.5 font-semibold">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Save Draft</span>
            </button>
            <button type="button" onclick="document.getElementById('save_action').value='save_close'; document.getElementById('blogPostForm').submit();" class="h-10 px-5 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center gap-2 font-bold">
                <span class="material-symbols-outlined text-[18px]">publish</span>
                <span>Save &amp; Publish</span>
            </button>
        </div>
    </div>

    <?php if ($flash_msg): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $flash_type === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span>
        <span><?= e($flash_msg) ?></span>
    </div>
    <?php endif; ?>

    <!-- Main Editor Form -->
    <form method="post" id="blogPostForm" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
        <input type="hidden" name="save_action" id="save_action" value="save_close">
        <input type="hidden" name="id" value="<?= $id ?>">

        <!-- ========================================== -->
        <!-- LEFT COLUMN: Primary Canvas (8 Columns)   -->
        <!-- ========================================== -->
        <div class="lg:col-span-8 flex flex-col space-y-6">

            <!-- Title & Permalink Card -->
            <div class="p-6 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-4">
                <div>
                    <label for="title" class="block font-label-md text-label-md text-on-surface mb-1 font-bold">
                        Article Title <span class="text-error">*</span>
                    </label>
                    <input type="text" id="title" name="title" required value="<?= e($form_title) ?>"
                           placeholder="e.g. How AI SEO and Generative Search are Transforming Organic Traffic in 2026"
                           class="w-full text-xl sm:text-2xl font-bold px-4 py-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary text-on-surface transition-colors"
                           oninput="autoGenerateSlug(this.value); autoGenerateMetaTitle(this.value);">
                </div>

                <!-- Slug / Permalink Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 text-sm text-on-surface-variant bg-surface-container-low/70 px-3.5 py-2.5 rounded-xl border border-outline-variant/30">
                    <span class="font-semibold text-outline shrink-0 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">link</span> Permalink:
                    </span>
                    <span class="text-outline text-xs truncate max-w-xs font-mono"><?= e(BASE_URL . 'blog/') ?></span>
                    <input type="text" id="slug" name="slug" value="<?= e($form_slug) ?>"
                           placeholder="auto-generated-slug"
                           class="flex-1 font-mono text-xs px-2.5 py-1 rounded-md bg-surface-container-lowest border border-outline-variant focus:outline-none focus:border-primary text-primary font-semibold">
                    <button type="button" onclick="regenerateSlug()" class="px-2 py-1 rounded text-xs bg-surface-container hover:bg-surface-container-high text-on-surface transition-colors shrink-0" title="Regenerate from title">
                        Regenerate
                    </button>
                </div>
            </div>

            <!-- Body Writing Canvas -->
            <div class="p-6 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 flex flex-col space-y-4">
                
                <!-- Editor / Preview Tab Switcher & Stats -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
                    <div class="flex items-center gap-2">
                        <button type="button" id="tabWrite" onclick="switchEditorTab('write')" class="px-4 py-2 rounded-lg font-label-md text-label-md font-bold transition-all bg-primary-container text-on-primary">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">edit_note</span> Write (HTML/Markdown)
                            </span>
                        </button>
                        <button type="button" id="tabPreview" onclick="switchEditorTab('preview')" class="px-4 py-2 rounded-lg font-label-md text-label-md font-semibold text-on-surface-variant hover:bg-surface-container transition-all">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[18px]">visibility</span> Live Preview
                            </span>
                        </button>
                    </div>

                    <!-- Reading Stats -->
                    <div class="flex items-center gap-3 text-xs text-on-surface-variant font-medium">
                        <span id="statWords" class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-outline">description</span> 0 words
                        </span>
                        <span>·</span>
                        <span id="statReadTime" class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px] text-outline">schedule</span> 1 min read
                        </span>
                    </div>
                </div>

                <!-- Rich Insertion Toolbar -->
                <div id="editorToolbar" class="flex flex-wrap items-center gap-1.5 p-2 bg-surface-container-low rounded-xl border border-outline-variant/30">
                    <!-- Headings -->
                    <div class="flex items-center gap-1 pr-1 border-r border-outline-variant/40">
                        <button type="button" onclick="insertTag('<h2>', '</h2>', 'Subheading Title')" class="toolbar-btn" title="Heading 2">H2</button>
                        <button type="button" onclick="insertTag('<h3>', '</h3>', 'Section Heading')" class="toolbar-btn" title="Heading 3">H3</button>
                        <button type="button" onclick="insertTag('<h4>', '</h4>', 'Minor Subheading')" class="toolbar-btn" title="Heading 4">H4</button>
                    </div>

                    <!-- Basic Text Formatting -->
                    <div class="flex items-center gap-1 pr-1 border-r border-outline-variant/40">
                        <button type="button" onclick="insertTag('<strong>', '</strong>', 'bold text')" class="toolbar-btn" title="Bold">
                            <span class="font-bold">B</span>
                        </button>
                        <button type="button" onclick="insertTag('<em>', '</em>', 'italic text')" class="toolbar-btn italic" title="Italic">
                            <span class="italic">I</span>
                        </button>
                        <button type="button" onclick="insertTag('<u>', '</u>', 'underlined text')" class="toolbar-btn" title="Underline">
                            <span class="underline">U</span>
                        </button>
                        <button type="button" onclick="insertTag('<mark>', '</mark>', 'highlighted text')" class="toolbar-btn" title="Highlight">
                            <span class="material-symbols-outlined text-[16px]">format_ink_highlighter</span>
                        </button>
                    </div>

                    <!-- Lists & Structure -->
                    <div class="flex items-center gap-1 pr-1 border-r border-outline-variant/40">
                        <button type="button" onclick="insertList(false)" class="toolbar-btn" title="Bullet List">
                            <span class="material-symbols-outlined text-[18px]">format_list_bulleted</span>
                        </button>
                        <button type="button" onclick="insertList(true)" class="toolbar-btn" title="Numbered List">
                            <span class="material-symbols-outlined text-[18px]">format_list_numbered</span>
                        </button>
                        <button type="button" onclick="insertTag('<blockquote>\n<p>', '</p>\n</blockquote>', 'Key quote or important statement here...')" class="toolbar-btn" title="Blockquote">
                            <span class="material-symbols-outlined text-[18px]">format_quote</span>
                        </button>
                        <button type="button" onclick="insertHr()" class="toolbar-btn" title="Horizontal Divider">
                            <span class="material-symbols-outlined text-[18px]">horizontal_rule</span>
                        </button>
                    </div>

                    <!-- Media & Rich Blocks -->
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="promptInsertLink()" class="toolbar-btn" title="Insert Link">
                            <span class="material-symbols-outlined text-[18px]">link</span>
                        </button>
                        <button type="button" onclick="openInlineImageModal()" class="toolbar-btn text-xs font-semibold px-2.5 flex items-center gap-1" title="Insert Image with Alt Text & Alt Description">
                            <span class="material-symbols-outlined text-[18px]">add_photo_alternate</span>
                            <span>Add Image</span>
                        </button>
                        <button type="button" onclick="insertTable()" class="toolbar-btn" title="Insert Table">
                            <span class="material-symbols-outlined text-[18px]">table_chart</span>
                        </button>
                        <button type="button" onclick="insertCallout()" class="toolbar-btn text-xs font-semibold px-2" title="Insert Key Insight Box">
                            💡 Callout
                        </button>
                    </div>
                </div>

                <!-- Write Area (Textarea) -->
                <div id="writePane" class="w-full">
                    <textarea id="body" name="body" rows="22" required
                              placeholder="Write your article here... HTML tags like <h2>, <p>, <ul>, <li>, <strong>, <blockquote> and <img> are supported."
                              class="w-full font-mono text-sm leading-relaxed p-4 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary text-on-surface transition-colors resize-y min-h-[460px]"
                              oninput="updateBodyStats()"><?= e($form_body) ?></textarea>
                </div>

                <!-- Live Preview Pane -->
                <div id="previewPane" class="w-full hidden p-6 bg-white rounded-xl border border-outline-variant/30 min-h-[460px] overflow-x-auto text-slate-800">
                    <div id="previewContent" class="post-body">
                        <!-- Rendered dynamically -->
                    </div>
                </div>
            </div>

            <!-- Excerpt / Meta Description Card -->
            <div class="p-6 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-3">
                <div class="flex items-center justify-between">
                    <label for="excerpt" class="block font-label-md text-label-md text-on-surface font-bold">
                        Article Excerpt &amp; Meta Description
                    </label>
                    <span id="excerptCount" class="text-xs text-outline font-mono">0 / 160 chars</span>
                </div>
                <textarea id="excerpt" name="excerpt" rows="3"
                          placeholder="Short summary displayed on the blog archive cards and Google SERP snippets (150-160 characters recommended)..."
                          class="w-full text-sm p-3.5 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary text-on-surface transition-colors"
                          oninput="updateExcerptCount(this.value)"><?= e($form_excerpt) ?></textarea>
                <p class="text-xs text-on-surface-variant">
                    Tip: A concise, compelling hook improves search click-through rates and social sharing preview cards.
                </p>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- RIGHT COLUMN: Metadata & Sidebar (4 Cols)  -->
        <!-- ========================================== -->
        <div class="lg:col-span-4 flex flex-col space-y-6">

            <!-- Publishing & Status Card -->
            <div class="p-5 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-4">
                <div class="flex items-center gap-2 border-b border-outline-variant/30 pb-3">
                    <span class="material-symbols-outlined text-[20px] text-primary">publish</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Publishing Status</h3>
                </div>

                <!-- Status Selector -->
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-2 font-medium">Article Visibility</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 p-3 rounded-xl bg-surface-container-low border-2 border-transparent has-[:checked]:border-primary has-[:checked]:bg-primary/5 cursor-pointer transition-colors">
                            <input type="radio" name="active" value="1" <?= $form_active == 1 ? 'checked' : '' ?> class="accent-[#0037b0]">
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md text-on-surface font-bold">Published</span>
                                <span class="text-[11px] text-outline">Live on site</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl bg-surface-container-low border-2 border-transparent has-[:checked]:border-secondary-container has-[:checked]:bg-secondary-container/10 cursor-pointer transition-colors">
                            <input type="radio" name="active" value="0" <?= $form_active == 0 ? 'checked' : '' ?> class="accent-[#fd651e]">
                            <div class="flex flex-col">
                                <span class="font-label-md text-label-md text-on-surface font-bold">Draft</span>
                                <span class="text-[11px] text-outline">Hidden</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Date & Time Picker -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="published_at" class="block font-label-md text-label-md text-on-surface font-medium">
                            Publish Date &amp; Time
                        </label>
                        <button type="button" onclick="setDateNow()" class="text-xs text-primary font-bold hover:underline">
                            Set to Now
                        </button>
                    </div>
                    <input type="datetime-local" id="published_at" name="published_at" value="<?= e($form_published_at) ?>"
                           class="w-full h-10 px-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface transition-colors">
                    <p class="text-[11px] text-on-surface-variant mt-1">Controls chronological sorting on the blog archive.</p>
                </div>

                <!-- Primary Submit Buttons in Sidebar -->
                <div class="pt-2 space-y-2">
                    <button type="submit" onclick="document.getElementById('save_action').value='save_close';" class="w-full h-11 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center justify-center gap-2 font-bold">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        <span>Save &amp; Return</span>
                    </button>
                    <button type="submit" onclick="document.getElementById('save_action').value='save_continue';" class="w-full h-10 rounded-xl bg-surface-container text-on-surface font-label-md text-label-md hover:bg-surface-container-high active:scale-95 transition-all flex items-center justify-center gap-1.5 font-semibold">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        <span>Save &amp; Keep Editing</span>
                    </button>
                </div>
            </div>

            <!-- Author & Designation Card -->
            <div class="p-5 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-4">
                <div class="flex items-center gap-2 border-b border-outline-variant/30 pb-3">
                    <span class="material-symbols-outlined text-[20px] text-primary">badge</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Author Information</h3>
                </div>

                <!-- Author Name -->
                <div>
                    <label for="author" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">
                        Author Name <span class="text-error">*</span>
                    </label>
                    <input type="text" id="author" name="author" required value="<?= e($form_author) ?>"
                           placeholder="e.g. Kishor, Jithu Gilbert, Ravi Sharma"
                           class="w-full h-10 px-3.5 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                    
                    <!-- Quick author suggestions -->
                    <div class="flex flex-wrap gap-1.5 mt-2">
                        <span class="text-[11px] text-outline self-center">Presets:</span>
                        <button type="button" onclick="setAuthor('<?= e($user['name'] ?? 'TechBound') ?>', 'Digital Growth Strategist')" class="px-2 py-0.5 rounded text-[11px] bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors">
                            <?= e($user['name'] ?? 'You') ?>
                        </button>
                        <button type="button" onclick="setAuthor('Kishor', 'Founder & Lead Strategist')" class="px-2 py-0.5 rounded text-[11px] bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors">
                            Kishor
                        </button>
                        <button type="button" onclick="setAuthor('Jithu Gilbert', 'Senior Digital Strategist')" class="px-2 py-0.5 rounded text-[11px] bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors">
                            Jithu Gilbert
                        </button>
                        <button type="button" onclick="setAuthor('TechBound Team', 'Editorial & Insights Desk')" class="px-2 py-0.5 rounded text-[11px] bg-surface-container hover:bg-surface-container-high text-on-surface-variant transition-colors">
                            TechBound Team
                        </button>
                    </div>
                </div>

                <!-- Author Designation / Role -->
                <div>
                    <label for="author_designation" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">
                        Author Designation / Role
                    </label>
                    <input type="text" id="author_designation" name="author_designation" value="<?= e($form_author_designation) ?>"
                           placeholder="e.g. Head of AI Search & SEO, Senior Strategist"
                           class="w-full h-10 px-3.5 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                    <p class="text-[11px] text-on-surface-variant mt-1">
                        Displayed on the article page alongside author byline.
                    </p>
                </div>
            </div>

            <!-- SEO Metadata Card -->
            <div class="p-5 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-4">
                <div class="flex items-center justify-between border-b border-outline-variant/30 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-primary">travel_explore</span>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">SEO Metadata</h3>
                    </div>
                    <button type="button" onclick="resetAutoMeta()" class="text-xs text-primary font-semibold hover:underline" title="Auto-fill from article title and excerpt">
                        Auto-fill
                    </button>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="meta_title" class="block font-label-md text-label-md text-on-surface font-medium">
                            Meta Title
                        </label>
                        <span id="metaTitleCount" class="text-[11px] text-outline">0 / 60</span>
                    </div>
                    <input type="text" id="meta_title" name="meta_title" value="<?= e($form_meta_title) ?>"
                           placeholder="Auto-generated from title"
                           class="w-full h-10 px-3.5 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface transition-colors">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="meta_description" class="block font-label-md text-label-md text-on-surface font-medium">
                            Meta Description
                        </label>
                        <span id="metaDescCount" class="text-[11px] text-outline">0 / 160</span>
                    </div>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              placeholder="Auto-generated from excerpt or content"
                              class="w-full p-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface transition-colors resize-none"><?= e($form_meta_description) ?></textarea>
                    <p class="text-[11px] text-on-surface-variant mt-1">Automatically generated from the article if left blank.</p>
                </div>
            </div>

            <!-- Category & SEO Tags Card -->
            <div class="p-5 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-4">
                <div class="flex items-center gap-2 border-b border-outline-variant/30 pb-3">
                    <span class="material-symbols-outlined text-[20px] text-primary">category</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Category &amp; Tags</h3>
                </div>

                <!-- Category Dropdown -->
                <div>
                    <label for="category" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">
                        Primary Category <span class="text-error">*</span>
                    </label>
                    <select id="category" name="category" onchange="handleCategoryChange(this.value)"
                            class="w-full h-10 px-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                        <?php 
                        $cat_matched = false;
                        foreach ($common_categories as $c): 
                            $sel = ($form_category === $c);
                            if ($sel) $cat_matched = true;
                        ?>
                            <option value="<?= e($c) ?>" <?= $sel ? 'selected' : '' ?>><?= e($c) ?></option>
                        <?php endforeach; ?>
                        <option value="__custom__" <?= !$cat_matched && $form_category !== '' ? 'selected' : '' ?>>+ Enter Custom Category...</option>
                    </select>
                </div>

                <!-- Custom Category Input (toggled if needed) -->
                <div id="customCategoryWrap" class="<?= ($cat_matched || $form_category === '') ? 'hidden' : '' ?>">
                    <label for="custom_category" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">Custom Category Name</label>
                    <input type="text" id="custom_category" name="custom_category" value="<?= !$cat_matched ? e($form_category) : '' ?>"
                           placeholder="e.g. Conversion Rate Optimization"
                           class="w-full h-10 px-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary text-on-surface font-body-md text-body-md transition-colors">
                </div>

                <!-- Focus Keywords / Tags -->
                <div>
                    <label for="tags" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">
                        Tags &amp; Keywords
                    </label>
                    <input type="text" id="tags" name="tags" value="<?= e($form_tags) ?>"
                           placeholder="e.g. AI SEO, Google SGE, Perplexity, Lead Gen"
                           class="w-full h-10 px-3.5 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                    <p class="text-[11px] text-on-surface-variant mt-1">Comma-separated keywords for search and related articles.</p>
                </div>
            </div>

            <!-- Featured Image & Placeholder Selector -->
            <div class="p-5 rounded-2xl bg-surface-container-lowest shadow-sm border border-outline-variant/30 space-y-4">
                <div class="flex items-center gap-2 border-b border-outline-variant/30 pb-3">
                    <span class="material-symbols-outlined text-[20px] text-primary">image</span>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">Featured Image</h3>
                </div>

                <!-- Live Preview Thumbnail -->
                <div class="w-full aspect-video rounded-xl bg-surface-container-low border border-outline-variant/40 overflow-hidden relative flex items-center justify-center group shadow-inner">
                    <img id="imgPreview" src="<?= e(blog_image_url($form_image, $form_category)) ?>" alt="Featured Image Preview"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null; this.src='<?= asset(blog_placeholder($form_category)) ?>';">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="text-white text-xs font-semibold px-2 py-1 bg-black/60 rounded">Live Banner Preview</span>
                    </div>
                </div>

                <!-- Image URL Input -->
                <div>
                    <label for="image" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">
                        Image URL / File Path
                    </label>
                    <input type="text" id="image" name="image" value="<?= e($form_image) ?>"
                           placeholder="https://... or assets/placeholders/blog-ai-seo.svg"
                           class="w-full h-10 px-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface transition-colors"
                           oninput="updateImagePreview(this.value)">
                </div>

                <!-- Image Alt Description (Unlimited) -->
                <div>
                    <label for="image_alt_description" class="block font-label-md text-label-md text-on-surface mb-1 font-medium">
                        Image Alt Description
                    </label>
                    <textarea id="image_alt_description" name="image_alt_description" rows="3"
                              placeholder="Detailed image alt description (no character limit)..."
                              class="w-full p-3 rounded-xl bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface transition-colors resize-y"><?= e($form_image_alt_description) ?></textarea>
                    <p class="text-[11px] text-on-surface-variant mt-1">No character limit.</p>
                </div>

                <!-- 1-Click Branded Placeholder Buttons -->
                <div>
                    <label class="block font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2 font-bold">
                        1-Click Branded Placeholders
                    </label>
                    <div class="grid grid-cols-2 gap-1.5">
                        <button type="button" onclick="setPlaceholder('assets/placeholders/blog-ai-seo.svg')" class="px-2 py-1.5 rounded-lg text-xs font-semibold bg-cyan-950/20 text-cyan-700 hover:bg-cyan-950/30 transition-colors text-left truncate flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span> AI SEO
                        </button>
                        <button type="button" onclick="setPlaceholder('assets/placeholders/blog-seo.svg')" class="px-2 py-1.5 rounded-lg text-xs font-semibold bg-emerald-950/20 text-emerald-700 hover:bg-emerald-950/30 transition-colors text-left truncate flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> SEO Search
                        </button>
                        <button type="button" onclick="setPlaceholder('assets/placeholders/blog-digital-marketing.svg')" class="px-2 py-1.5 rounded-lg text-xs font-semibold bg-green-950/20 text-green-700 hover:bg-green-950/30 transition-colors text-left truncate flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Digital Mktg
                        </button>
                        <button type="button" onclick="setPlaceholder('assets/placeholders/blog-smm.svg')" class="px-2 py-1.5 rounded-lg text-xs font-semibold bg-purple-950/20 text-purple-700 hover:bg-purple-950/30 transition-colors text-left truncate flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span> Social Media
                        </button>
                        <button type="button" onclick="setPlaceholder('assets/placeholders/blog-web-dev.svg')" class="px-2 py-1.5 rounded-lg text-xs font-semibold bg-blue-950/20 text-blue-700 hover:bg-blue-950/30 transition-colors text-left truncate flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Web &amp; Tech
                        </button>
                        <button type="button" onclick="setPlaceholder('assets/placeholders/blog-default.svg')" class="px-2 py-1.5 rounded-lg text-xs font-semibold bg-slate-900/10 text-slate-700 hover:bg-slate-900/20 transition-colors text-left truncate flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-slate-500"></span> TechBound
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
.toolbar-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 6px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--on-surface);
    background: transparent;
    transition: background-color 0.15s, color 0.15s;
}
.toolbar-btn:hover {
    background: rgba(0, 55, 176, 0.12);
    color: #0037b0;
}
</style>

<script>
// Auto Slug Generator
function autoGenerateSlug(title) {
    const slugInput = document.getElementById('slug');
    // Only auto-generate if user hasn't typed a custom slug or if slug was empty
    if (!slugInput.dataset.manual) {
        slugInput.value = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .trim()
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
}

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.manual = 'true';
});

function regenerateSlug() {
    const title = document.getElementById('title').value;
    const slugInput = document.getElementById('slug');
    slugInput.dataset.manual = '';
    autoGenerateSlug(title);
}

// Author & Designation Preset helper
function setAuthor(name, designation) {
    document.getElementById('author').value = name;
    if (designation) {
        document.getElementById('author_designation').value = designation;
    }
}

// Date Now helper
function setDateNow() {
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('published_at').value = now.toISOString().slice(0, 16);
}

// Category custom handler
function handleCategoryChange(val) {
    const wrap = document.getElementById('customCategoryWrap');
    if (val === '__custom__') {
        wrap.classList.remove('hidden');
        document.getElementById('custom_category').focus();
    } else {
        wrap.classList.add('hidden');
    }
}

// Image Preview & Placeholders
function updateImagePreview(url) {
    const img = document.getElementById('imgPreview');
    if (url.trim() === '') {
        const cat = document.getElementById('category').value;
        img.src = '<?= asset('assets/placeholders/blog-default.svg') ?>';
    } else if (url.startsWith('http://') || url.startsWith('https://')) {
        img.src = url;
    } else {
        img.src = '<?= BASE_URL ?>' + url.replace(/^\//, '');
    }
}

function setPlaceholder(path) {
    document.getElementById('image').value = path;
    updateImagePreview(path);
}

// Character & Word counters
function updateExcerptCount(val) {
    document.getElementById('excerptCount').textContent = val.length + ' / 160 chars';
}

function updateBodyStats() {
    const text = document.getElementById('body').value.replace(/<[^>]*>/g, ' ');
    const words = text.trim().split(/\s+/).filter(w => w.length > 0).length;
    document.getElementById('statWords').innerHTML = '<span class="material-symbols-outlined text-[16px] text-outline">description</span> ' + words + ' words';
    const minutes = Math.max(1, Math.ceil(words / 200));
    document.getElementById('statReadTime').innerHTML = '<span class="material-symbols-outlined text-[16px] text-outline">schedule</span> ' + minutes + ' min read';
}

// Switch between Write and Live Preview
function switchEditorTab(tab) {
    const writePane = document.getElementById('writePane');
    const previewPane = document.getElementById('previewPane');
    const tabWrite = document.getElementById('tabWrite');
    const tabPreview = document.getElementById('tabPreview');
    const toolbar = document.getElementById('editorToolbar');

    if (tab === 'write') {
        writePane.classList.remove('hidden');
        toolbar.classList.remove('hidden');
        previewPane.classList.add('hidden');
        tabWrite.className = 'px-4 py-2 rounded-lg font-label-md text-label-md font-bold transition-all bg-primary-container text-on-primary';
        tabPreview.className = 'px-4 py-2 rounded-lg font-label-md text-label-md font-semibold text-on-surface-variant hover:bg-surface-container transition-all';
    } else {
        writePane.classList.add('hidden');
        toolbar.classList.add('hidden');
        previewPane.classList.remove('hidden');
        tabWrite.className = 'px-4 py-2 rounded-lg font-label-md text-label-md font-semibold text-on-surface-variant hover:bg-surface-container transition-all';
        tabPreview.className = 'px-4 py-2 rounded-lg font-label-md text-label-md font-bold transition-all bg-primary-container text-on-primary';
        
        // Render content inside preview
        const rawBody = document.getElementById('body').value;
        document.getElementById('previewContent').innerHTML = rawBody || '<p class="text-slate-400 italic">No content written yet. Switch back to Write to add your text.</p>';
    }
}

// Textarea Insertion Helpers
function insertTag(openTag, closeTag, defaultText) {
    const textarea = document.getElementById('body');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const selected = textarea.value.substring(start, end) || defaultText;
    const replacement = openTag + selected + closeTag;

    textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
    textarea.focus();
    textarea.selectionStart = start + openTag.length;
    textarea.selectionEnd = start + openTag.length + selected.length;
    updateBodyStats();
}

function insertList(ordered) {
    const textarea = document.getElementById('body');
    const tag = ordered ? 'ol' : 'ul';
    const listHtml = '\n<' + tag + '>\n  <li>Key point one</li>\n  <li>Key point two</li>\n  <li>Key point three</li>\n</' + tag + '>\n';
    insertRaw(listHtml);
}

function insertHr() {
    insertRaw('\n<hr style="margin: 32px 0; border: none; border-top: 1px solid #e2e8f0;">\n');
}

function insertTable() {
    const tableHtml = '\n<div style="overflow-x:auto; margin:24px 0;">\n  <table style="width:100%; border-collapse:collapse; text-align:left;">\n    <thead>\n      <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">\n        <th style="padding:12px;">Feature</th>\n        <th style="padding:12px;">Classic SEO</th>\n        <th style="padding:12px;">AI SEO</th>\n      </tr>\n    </thead>\n    <tbody>\n      <tr style="border-bottom:1px solid #e2e8f0;">\n        <td style="padding:12px; font-weight:600;">Discovery</td>\n        <td style="padding:12px;">10 Blue Links</td>\n        <td style="padding:12px;">Direct AI Synthesis</td>\n      </tr>\n    </tbody>\n  </table>\n</div>\n';
    insertRaw(tableHtml);
}

function insertCallout() {
    const calloutHtml = '\n<div style="background:#f0fdf4; border-left:4px solid #00a651; padding:18px 22px; border-radius:10px; margin:24px 0;">\n  <h4 style="margin:0 0 6px 0; color:#14532d; font-size:16px;">💡 Key Takeaway</h4>\n  <p style="margin:0; color:#166534; font-size:14.5px;">Add your actionable tip or summary point here.</p>\n</div>\n';
    insertRaw(calloutHtml);
}

function promptInsertLink() {
    const url = prompt('Enter the link URL (e.g. https://example.com):', 'https://');
    if (url && url !== 'https://') {
        const text = prompt('Enter the link text (optional):', 'read more');
        insertRaw('<a href="' + url + '" target="_blank" rel="noopener noreferrer" style="color:#00a651; font-weight:600; text-decoration:underline;">' + (text || url) + '</a>');
    }
}

function promptInsertImage() {
    openInlineImageModal();
}

function escapeHtmlAttr(str) {
    return String(str || '')
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function openInlineImageModal() {
    const modal = document.getElementById('inlineImageModal');
    if (!modal) return;
    document.getElementById('inlineImgUrl').value = '';
    document.getElementById('inlineImgFile').value = '';
    document.getElementById('inlineImgAlt').value = '';
    document.getElementById('inlineImgAltDesc').value = '';
    document.getElementById('inlineImgShowCaption').checked = true;
    document.getElementById('inlineImgPreviewWrap').classList.add('hidden');
    document.getElementById('inlineImgStatus').textContent = '';
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => document.getElementById('inlineImgAlt').focus(), 60);
}

function closeInlineImageModal() {
    const modal = document.getElementById('inlineImageModal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function previewInlineImageUrl(url) {
    const wrap = document.getElementById('inlineImgPreviewWrap');
    const img  = document.getElementById('inlineImgPreview');
    const clean = (url || '').trim();
    if (!clean) {
        wrap.classList.add('hidden');
        return;
    }
    img.src = (clean.startsWith('http://') || clean.startsWith('https://') || clean.startsWith('/'))
        ? clean
        : ('<?= BASE_URL ?>' + clean.replace(/^\//, ''));
    wrap.classList.remove('hidden');
}

async function handleInlineImageUpload(input) {
    if (!input.files || !input.files[0]) return;
    const status = document.getElementById('inlineImgStatus');
    const urlInput = document.getElementById('inlineImgUrl');
    const fd = new FormData();
    fd.append('_csrf', '<?= e($csrf) ?>');
    fd.append('image', input.files[0]);

    status.className = 'text-xs text-slate-500 mt-1';
    status.textContent = 'Uploading image...';

    try {
        const res = await fetch('<?= e(admin_url('resources/upload_blog_image.php')) ?>', {
            method: 'POST',
            body: fd
        });
        const data = await res.json();
        if (!res.ok || !data.ok) {
            throw new Error(data.message || 'Image upload failed.');
        }
        urlInput.value = data.url;
        previewInlineImageUrl(data.url);
        status.className = 'text-xs text-emerald-700 font-semibold mt-1';
        status.textContent = 'Uploaded cleanly to ' + data.path;
    } catch (err) {
        status.className = 'text-xs text-red-600 font-semibold mt-1';
        status.textContent = err.message || 'Upload failed.';
    }
}

function insertInlineImageFromModal() {
    const urlVal  = (document.getElementById('inlineImgUrl').value || '').trim();
    const altVal  = (document.getElementById('inlineImgAlt').value || '').trim();
    const descVal = (document.getElementById('inlineImgAltDesc').value || '').trim();
    const showCap = document.getElementById('inlineImgShowCaption').checked;
    const status  = document.getElementById('inlineImgStatus');

    if (!urlVal) {
        status.className = 'text-xs text-red-600 font-semibold mt-1';
        status.textContent = 'Please upload an image or enter an image URL first.';
        return;
    }
    if (!altVal) {
        status.className = 'text-xs text-red-600 font-semibold mt-1';
        status.textContent = 'Please enter Image Alt Text for accessibility and SEO.';
        document.getElementById('inlineImgAlt').focus();
        return;
    }

    const src = (urlVal.startsWith('http://') || urlVal.startsWith('https://') || urlVal.startsWith('/'))
        ? urlVal
        : ('<?= BASE_URL ?>' + urlVal.replace(/^\//, ''));

    const descAttr = descVal ? ' data-alt-description="' + escapeHtmlAttr(descVal) + '"' : '';
    const captionText = descVal || altVal;
    const figcaptionHtml = (showCap && captionText)
        ? '\n  <figcaption style="font-size:13px; color:#5b6962; margin-top:10px; line-height:1.55;">' + escapeHtmlAttr(captionText) + '</figcaption>'
        : '';

    const imgHtml =
        '\n<figure class="blog-inline-figure" style="margin:28px 0; text-align:center;">\n' +
        '  <img src="' + escapeHtmlAttr(src) + '" alt="' + escapeHtmlAttr(altVal) + '"' + descAttr + ' loading="lazy" style="max-width:100%; border-radius:14px; box-shadow:0 8px 24px rgba(0,0,0,0.08);">' +
        figcaptionHtml +
        '\n</figure>\n';

    insertRaw(imgHtml);
    closeInlineImageModal();
}

function insertRaw(html) {
    const textarea = document.getElementById('body');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    textarea.value = textarea.value.substring(0, start) + html + textarea.value.substring(end);
    textarea.focus();
    textarea.selectionStart = textarea.selectionEnd = start + html.length;
    updateBodyStats();
}

// Auto Meta Title & Meta Description Generators
function updateMetaCounts() {
    const mt = document.getElementById('meta_title');
    const md = document.getElementById('meta_description');
    if (mt) document.getElementById('metaTitleCount').textContent = mt.value.length + ' / 60';
    if (md) document.getElementById('metaDescCount').textContent = md.value.length + ' / 160';
}

function autoGenerateMetaTitle(title) {
    const mt = document.getElementById('meta_title');
    if (!mt || mt.dataset.manual === 'true') return;
    const clean = title.trim();
    mt.value = clean ? (clean + ' | TechBound') : '';
    updateMetaCounts();
}

function autoGenerateMetaDescription() {
    const md = document.getElementById('meta_description');
    if (!md || md.dataset.manual === 'true') return;
    const excerpt = (document.getElementById('excerpt')?.value || '').trim();
    const bodyText = (document.getElementById('body')?.value || '').replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
    const source = excerpt || bodyText;
    md.value = source.slice(0, 160);
    updateMetaCounts();
}

function resetAutoMeta() {
    const mt = document.getElementById('meta_title');
    const md = document.getElementById('meta_description');
    if (mt) mt.dataset.manual = '';
    if (md) md.dataset.manual = '';
    autoGenerateMetaTitle(document.getElementById('title')?.value || '');
    autoGenerateMetaDescription();
}

document.getElementById('meta_title')?.addEventListener('input', function() {
    this.dataset.manual = this.value.trim() !== '' ? 'true' : '';
    updateMetaCounts();
});

document.getElementById('meta_description')?.addEventListener('input', function() {
    this.dataset.manual = this.value.trim() !== '' ? 'true' : '';
    updateMetaCounts();
});

document.getElementById('excerpt')?.addEventListener('input', autoGenerateMetaDescription);
document.getElementById('body')?.addEventListener('input', autoGenerateMetaDescription);

// Initial count triggers
window.addEventListener('DOMContentLoaded', function() {
    updateBodyStats();
    updateExcerptCount(document.getElementById('excerpt').value);
    const mt = document.getElementById('meta_title');
    const md = document.getElementById('meta_description');
    if (mt && mt.value.trim() !== '') mt.dataset.manual = 'true';
    if (md && md.value.trim() !== '') md.dataset.manual = 'true';
    autoGenerateMetaTitle(document.getElementById('title')?.value || '');
    autoGenerateMetaDescription();
    updateMetaCounts();
});
</script>

<!-- Inline Image Insertion Modal (Upload/URL + Alt Text + Alt Description) -->
<div id="inlineImageModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="inlineImageModalTitle">
    <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-700">add_photo_alternate</span>
                <h3 id="inlineImageModalTitle" class="text-base font-bold text-slate-900">Insert Image into Article</h3>
            </div>
            <button type="button" onclick="closeInlineImageModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors" aria-label="Close">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
            <!-- Upload from computer -->
            <div>
                <label for="inlineImgFile" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Upload Image File</label>
                <input type="file" id="inlineImgFile" accept="image/jpeg,image/png,image/webp,image/gif,image/avif"
                       onchange="handleInlineImageUpload(this)"
                       class="block w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-200 rounded-xl p-1.5 bg-slate-50">
                <p id="inlineImgStatus" class="text-xs text-slate-500 mt-1"></p>
            </div>

            <!-- Or Image URL -->
            <div>
                <label for="inlineImgUrl" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Or Image URL</label>
                <input type="text" id="inlineImgUrl" oninput="previewInlineImageUrl(this.value)"
                       placeholder="https://... or assets/blog/your-image.jpg"
                       class="w-full text-sm px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:border-emerald-600 focus:bg-white">
            </div>

            <!-- Live Preview -->
            <div id="inlineImgPreviewWrap" class="hidden rounded-xl overflow-hidden border border-slate-200 bg-slate-50 p-2 text-center">
                <img id="inlineImgPreview" src="" alt="Preview" class="max-h-44 mx-auto rounded-lg object-contain">
            </div>

            <!-- Alt Text -->
            <div>
                <label for="inlineImgAlt" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Image Alt Text <span class="text-red-500">*</span>
                </label>
                <input type="text" id="inlineImgAlt"
                       placeholder="Concise description for SEO & screen readers (e.g. Google Search Console organic clicks chart)"
                       class="w-full text-sm px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:border-emerald-600 focus:bg-white">
            </div>

            <!-- Alt Description (Unlimited) -->
            <div>
                <label for="inlineImgAltDesc" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                    Image Alt Description <span class="font-normal text-slate-400 normal-case">(no length limit)</span>
                </label>
                <textarea id="inlineImgAltDesc" rows="3"
                          placeholder="Detailed image alt description or explanatory caption..."
                          class="w-full text-sm px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:border-emerald-600 focus:bg-white resize-y"></textarea>
            </div>

            <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer select-none">
                <input type="checkbox" id="inlineImgShowCaption" checked class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <span>Show Alt Description as visible caption under the image</span>
            </label>
        </div>

        <div class="flex items-center justify-end gap-2 px-6 py-4 border-t border-slate-200 bg-slate-50">
            <button type="button" onclick="closeInlineImageModal()" class="px-4 py-2 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-200 transition-colors">
                Cancel
            </button>
            <button type="button" onclick="insertInlineImageFromModal()" class="px-5 py-2 rounded-lg text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">check</span>
                <span>Insert Image</span>
            </button>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../_footer.php'; ?>
