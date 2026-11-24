<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();

function default_site_testimonials(): array {
    return [
        ['client' => 'Biju Kesavan',     'role' => 'SEO & Website Growth',           'quote' => 'I approached TechBound Innovations for our website to increase our website calls and maintain the top position. As they promised us, their strategies increased our website calls and maintain our websites in top position. No wonder they are the top digital marketing agency in Kerala. I highly recommend them to you.', 'sort_order' => 1],
        ['client' => 'Abhai Sasidharan', 'role' => 'Digital Marketing Partner',      'quote' => 'TechBound has been a great Digital Marketing partner over the last 5 years. We highly recommend them if you are in need of their Digital Marketing Services. The team is very responsive, professional and full of knowledge.', 'sort_order' => 2],
        ['client' => 'Firos Hussain',    'role' => 'Digital Marketing Strategy',     'quote' => 'Working with TechBound Digital Marketing Company has been a wonderful experience. The team is very experienced, insightful, and extremely skilled. Their custom Digital Marketing Strategies generate excellent results across the last few months. I have recommended their services to anyone who wants to take their digital activities to the next level.', 'sort_order' => 3],
        ['client' => 'Princy Antony',    'role' => 'Digital Marketing Client',       'quote' => 'Having had bad experiences with digital marketing agencies for many years, we have used TechBound Digital Marketing Agency since Feb 2022 and I have been extremely impressed by the work and results they have brought our company in a relatively short space of time. Would strongly recommend TechBound to anyone looking for a solid, reliable digital agency that can deliver results.', 'sort_order' => 4],
        ['client' => 'SM Hilur',         'role' => 'Business Growth Client',         'quote' => 'I adore this Digital Marketing Company. With their new and "fresh" ideas, they have helped my company grow and expand. I\'ve had nothing but positive experiences with their team members, and their customer service is excellent. I highly recommend TechBound Digital Marketing Agency if you are looking for a company that is attentive to your business goals and needs.', 'sort_order' => 5],
        ['client' => 'Mihila L',         'role' => 'SEO & Marketing Consulting',     'quote' => 'Regardless of how urgent our needs were, the TechBound team responded quickly and professionally. Anyone in need of marketing services should get in touch with them. They have long served as our marketing consultants. The team is always responsive, honest, and professional. Our website ranks have significantly improved as a result of TechBound Digital Marketing agency\'s advice.', 'sort_order' => 6],
        ['client' => 'Client',           'role' => 'Digital Growth',                 'quote' => 'TechBound understood our goals and helped us strengthen our online presence.', 'sort_order' => 7],
        ['client' => 'Client',           'role' => 'Web Development',                'quote' => 'The team was professional, responsive and focused on delivering quality work.', 'sort_order' => 8],
        ['client' => 'Client',           'role' => 'Marketing',                      'quote' => 'Our digital strategy became clearer, more consistent and better aligned with our goals.', 'sort_order' => 9],
        ['client' => 'Client',           'role' => 'Brand Strategy',                 'quote' => 'A supportive team that understands the importance of a strong brand.', 'sort_order' => 10],
        ['client' => 'Client',           'role' => 'Website Design',                 'quote' => 'The website looks modern, works smoothly and represents our business well.', 'sort_order' => 11],
        ['client' => 'Client',           'role' => 'Digital Services',               'quote' => 'We appreciated the clear communication and attention to detail throughout the project.', 'sort_order' => 12],
        ['client' => 'Client',           'role' => 'Business Growth',                'quote' => 'The team worked with us to find practical solutions for our business.', 'sort_order' => 13],
        ['client' => 'Client',           'role' => 'Project Delivery',               'quote' => 'A great experience from planning through execution and delivery.', 'sort_order' => 14],
    ];
}

if ($pdo) {
    try {
        if ((int)$pdo->query('SELECT COUNT(*) FROM testimonials')->fetchColumn() === 0) {
            $ins = $pdo->prepare('INSERT INTO testimonials (quote, client, role, sort_order, active) VALUES (?, ?, ?, ?, 1)');
            foreach (default_site_testimonials() as $t) {
                $ins->execute([$t['quote'], $t['client'], $t['role'], $t['sort_order']]);
            }
        }
    } catch (Throwable $e) {}
}

$action = $_POST['_action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . admin_url('resources/testimonials.php?flash=' . urlencode('error:Cannot modify testimonials while database is disconnected.')));
        exit;
    }
    if ($action === 'save') {
        $id         = (int)($_POST['id'] ?? 0);
        $quote      = trim($_POST['quote']      ?? '');
        $client     = trim($_POST['client']     ?? '');
        $role       = trim($_POST['role']       ?? '');
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $active     = isset($_POST['active']) ? 1 : 0;

        if ($quote === '' || $client === '') {
            $flash = 'error:Quote and Client name are required.';
        } else {
            if ($id) {
                $pdo->prepare('UPDATE testimonials SET quote=?,client=?,role=?,sort_order=?,active=? WHERE id=?')
                    ->execute([$quote, $client, $role, $sort_order, $active, $id]);
                $flash = 'success:Testimonial updated.';
            } else {
                $pdo->prepare('INSERT INTO testimonials (quote,client,role,sort_order,active) VALUES (?,?,?,?,?)')
                    ->execute([$quote, $client, $role, $sort_order, $active]);
                $flash = 'success:Testimonial added.';
            }
            header('Location: ' . admin_url('resources/testimonials.php?flash=' . urlencode($flash)));
            exit;
        }
    }
    if ($action === 'delete' && !empty($_POST['id'])) {
        $pdo->prepare('DELETE FROM testimonials WHERE id=?')->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/testimonials.php?flash=' . urlencode('success:Testimonial deleted.')));
        exit;
    }
    if ($action === 'toggle' && !empty($_POST['id'])) {
        $pdo->prepare('UPDATE testimonials SET active = 1 - active WHERE id=?')->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/testimonials.php'));
        exit;
    }
}

$flash = $flash ?? urldecode($_GET['flash'] ?? '');
[$flash_type, $flash_msg] = $flash ? explode(':', $flash, 2) : ['', ''];

$editing      = null;
$rows         = [];
$total        = 0;
$active_count = 0;

if ($pdo) {
    try {
        if (!empty($_GET['edit'])) {
            $s = $pdo->prepare('SELECT * FROM testimonials WHERE id=?');
            $s->execute([(int)$_GET['edit']]);
            $editing = $s->fetch();
        }
        $rows  = $pdo->query('SELECT * FROM testimonials ORDER BY sort_order ASC, id ASC')->fetchAll();
        $total = count($rows);
        $active_count = count(array_filter($rows, fn($r) => $r['active']));
    } catch (Throwable $e) {}
}

$page_title = 'Testimonials & Reviews';
require __DIR__ . '/../_header.php';
?>

<div class="flex flex-col w-full">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Testimonials &amp; Reviews</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Testimonials &amp; Reviews</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Client reviews displayed on the TechBound website</p>
        </div>
        <div class="flex items-center gap-space-sm shrink-0">
            <div class="flex items-center gap-space-xs px-3 py-1.5 rounded-lg bg-surface-container font-label-md text-label-md text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary">star</span>
                <span><?= $active_count ?> active</span>
                <span class="text-outline">/ <?= $total ?> total</span>
            </div>
            <button onclick="openTestimonialForm()" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span> Add Testimonial
            </button>
        </div>
    </div>

    <?php if ($flash_msg): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $flash_type === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span> <?= e($flash_msg) ?>
    </div>
    <?php endif; ?>

    <!-- Cards Grid -->
    <?php if (empty($rows)): ?>
    <div class="rounded-xl bg-surface-container-lowest shadow-sm py-16 flex flex-col items-center gap-4 text-on-surface-variant">
        <span class="material-symbols-outlined text-[48px] text-outline">rate_review</span>
        <span class="font-body-md text-body-md">No testimonials yet. Add your first one!</span>
        <button onclick="openTestimonialForm()" class="h-9 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg">Add Testimonial</button>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-space-md">
        <?php foreach ($rows as $row):
            $initials = strtoupper(substr($row['client'], 0, 1) . (strpos($row['client'], ' ') !== false ? substr($row['client'], strpos($row['client'], ' ') + 1, 1) : ''));
            $colors   = ['bg-primary-container text-on-primary', 'bg-tertiary-container text-on-tertiary', 'bg-secondary-fixed text-on-secondary-fixed'];
            $color    = $colors[$row['id'] % 3];
        ?>
        <div class="rounded-lg bg-white border border-outline-variant flex flex-col p-5 <?= !$row['active'] ? 'opacity-60' : '' ?>">
            <!-- Quote -->
            <blockquote class="font-body-md text-body-md text-on-surface flex-1 mb-4 leading-relaxed">
                "<?= e($row['quote']) ?>"
            </blockquote>
            <!-- Client info -->
            <div class="flex items-center gap-space-sm border-t border-outline-variant/20 pt-space-sm">
                <div class="w-10 h-10 rounded-full <?= $color ?> font-label-lg text-label-lg flex items-center justify-center shrink-0 font-bold"><?= $initials ?></div>
                <div class="flex flex-col min-w-0 flex-1">
                    <span class="font-label-lg text-label-lg text-on-surface font-semibold truncate"><?= e($row['client']) ?></span>
                    <span class="font-body-sm text-body-sm text-on-surface-variant truncate"><?= e($row['role'] ?: 'Client') ?></span>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    <form method="post" class="inline">
                        <input type="hidden" name="_action" value="toggle">
                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                        <button type="submit" title="<?= $row['active'] ? 'Hide' : 'Show' ?>" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center transition-colors <?= $row['active'] ? 'text-primary' : 'text-outline' ?>">
                            <span class="material-symbols-outlined text-[18px]"><?= $row['active'] ? 'visibility' : 'visibility_off' ?></span>
                        </button>
                    </form>
                    <a href="?edit=<?= (int)$row['id'] ?>" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Edit">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </a>
                    <form method="post" onsubmit="return confirm('Delete this testimonial?')" class="inline">
                        <input type="hidden" name="_action" value="delete">
                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                        <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Testimonial Form Drawer -->
<div id="testimonialDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-on-surface/40 backdrop-blur-sm" onclick="closeTestimonialForm()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-surface-container-lowest shadow-2xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/30 shrink-0">
            <h2 id="testimonialDrawerTitle" class="font-headline-sm text-headline-sm text-on-surface">Add Testimonial</h2>
            <button onclick="closeTestimonialForm()" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form method="post" id="testimonialForm" class="flex flex-col flex-1 overflow-y-auto">
            <input type="hidden" name="_action" value="save">
            <input type="hidden" name="id" id="tf-id" value="">
            <div class="p-space-lg space-y-space-md flex-1">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="tf-quote">Quote / Review <span class="text-error">*</span></label>
                    <textarea id="tf-quote" name="quote" rows="5" required class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface resize-none transition-colors" placeholder="What did the client say about TechBound..."></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="tf-client">Client Name <span class="text-error">*</span></label>
                    <input type="text" id="tf-client" name="client" required class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="e.g. Ravi Sharma">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="tf-role">Client Role / Company</label>
                    <input type="text" id="tf-role" name="role" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="e.g. CEO, TechStartup Kerala">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="tf-order">Sort Order</label>
                    <input type="number" id="tf-order" name="sort_order" min="0" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" value="0">
                </div>
                <label class="flex items-center gap-space-sm cursor-pointer select-none">
                    <div class="relative">
                        <input type="checkbox" id="tf-active" name="active" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-surface-container-high rounded-full peer-checked:bg-primary transition-colors"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="font-label-lg text-label-lg text-on-surface">Active (visible on site)</span>
                </label>
            </div>
            <div class="px-space-lg py-space-md border-t border-outline-variant/30 flex justify-end gap-space-sm shrink-0">
                <button type="button" onclick="closeTestimonialForm()" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">Cancel</button>
                <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const editingTestimonial = <?= $editing ? json_encode($editing) : 'null' ?>;

function openTestimonialForm(data) {
    const drawer = document.getElementById('testimonialDrawer');
    if (data) {
        document.getElementById('testimonialDrawerTitle').textContent = 'Edit Testimonial';
        document.getElementById('tf-id').value     = data.id;
        document.getElementById('tf-quote').value  = data.quote  || '';
        document.getElementById('tf-client').value = data.client || '';
        document.getElementById('tf-role').value   = data.role   || '';
        document.getElementById('tf-order').value  = data.sort_order ?? 0;
        document.getElementById('tf-active').checked = data.active == 1;
    } else {
        document.getElementById('testimonialDrawerTitle').textContent = 'Add Testimonial';
        document.getElementById('testimonialForm').reset();
        document.getElementById('tf-id').value = '';
    }
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
}
function closeTestimonialForm() {
    document.getElementById('testimonialDrawer').classList.add('hidden');
    document.getElementById('testimonialDrawer').classList.remove('flex');
    history.replaceState(null, '', '?');
}
if (editingTestimonial) openTestimonialForm(editingTestimonial);
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
