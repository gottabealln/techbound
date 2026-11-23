<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();

$action = $_POST['_action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . admin_url('resources/services.php?flash=' . urlencode('error:Cannot modify services while database is disconnected.')));
        exit;
    }
    if ($action === 'save') {
        $id         = (int)($_POST['id'] ?? 0);
        $title      = trim($_POST['title']      ?? '');
        $slug       = trim($_POST['slug']       ?? '');
        $intro      = trim($_POST['intro']      ?? '');
        $items      = trim($_POST['items']      ?? '');
        $image      = trim($_POST['image']      ?? '');
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $active     = isset($_POST['active']) ? 1 : 0;

        if ($title === '') {
            $flash = 'error:Title is required.';
        } else {
            if ($slug === '') $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
            if ($id) {
                $pdo->prepare('UPDATE services SET title=?,slug=?,intro=?,items=?,image=?,sort_order=?,active=? WHERE id=?')
                    ->execute([$title, $slug, $intro, $items, $image, $sort_order, $active, $id]);
                $flash = 'success:Service updated successfully.';
            } else {
                $pdo->prepare('INSERT INTO services (title,slug,intro,items,image,sort_order,active) VALUES (?,?,?,?,?,?,?)')
                    ->execute([$title, $slug, $intro, $items, $image, $sort_order, $active]);
                $flash = 'success:Service created successfully.';
            }
            header('Location: ' . admin_url('resources/services.php?flash=' . urlencode($flash)));
            exit;
        }
    }
    if ($action === 'delete' && !empty($_POST['id'])) {
        $pdo->prepare('DELETE FROM services WHERE id=?')->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/services.php?flash=' . urlencode('success:Service deleted.')));
        exit;
    }
    if ($action === 'toggle' && !empty($_POST['id'])) {
        $pdo->prepare('UPDATE services SET active = 1 - active WHERE id=?')->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/services.php'));
        exit;
    }
}

$flash = $flash ?? urldecode($_GET['flash'] ?? '');
[$flash_type, $flash_msg] = $flash ? explode(':', $flash, 2) : ['', ''];

$editing = null;
$rows    = [];
$total   = 0;

if ($pdo) {
    try {
        if (!empty($_GET['edit'])) {
            $s = $pdo->prepare('SELECT * FROM services WHERE id=?');
            $s->execute([(int)$_GET['edit']]);
            $editing = $s->fetch();
        }
        $rows  = $pdo->query('SELECT * FROM services ORDER BY sort_order ASC, id ASC')->fetchAll();
        $total = count($rows);
    } catch (Throwable $e) {}
}

$page_title = 'Services';
require __DIR__ . '/../_header.php';
?>

<div class="flex flex-col w-full">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Services</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Services</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Manage the core services offered by TechBound Innovations</p>
        </div>
        <div class="flex items-center gap-space-sm shrink-0">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container font-label-md text-label-md text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary">layers</span>
                <?= $total ?> service<?= $total !== 1 ? 's' : '' ?>
            </span>
            <button onclick="openServiceForm()" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span> New Service
            </button>
        </div>
    </div>

    <?php if ($flash_msg): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $flash_type === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span> <?= e($flash_msg) ?>
    </div>
    <?php endif; ?>

    <!-- Services Grid -->
    <?php if (empty($rows)): ?>
    <div class="rounded-xl bg-surface-container-lowest shadow-sm py-16 flex flex-col items-center gap-4 text-on-surface-variant">
        <span class="material-symbols-outlined text-[48px] text-outline">design_services</span>
        <span class="font-body-md text-body-md">No services yet. Add your first service!</span>
        <button onclick="openServiceForm()" class="h-9 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg">Add Service</button>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-space-md">
        <?php foreach ($rows as $row): ?>
        <div class="rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-all duration-200 flex flex-col overflow-hidden group">
            <?php if ($row['image']): ?>
            <div class="h-36 bg-surface-container overflow-hidden relative">
                <img src="<?= e($row['image']) ?>" alt="<?= e($row['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            <?php else: ?>
            <div class="h-24 bg-surface-container-low flex items-center justify-center">
                <span class="material-symbols-outlined text-[40px] text-outline">design_services</span>
            </div>
            <?php endif; ?>
            <div class="p-space-md flex flex-col flex-1">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div class="flex flex-col min-w-0">
                        <h3 class="font-headline-sm text-headline-sm text-on-surface truncate"><?= e($row['title']) ?></h3>
                        <span class="font-label-sm text-label-sm text-outline mt-0.5"><?= e($row['slug']) ?></span>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <form method="post" class="inline">
                            <input type="hidden" name="_action" value="toggle">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full font-label-sm text-label-sm font-semibold transition-colors
                                <?= $row['active'] ? 'bg-surface-container-high text-primary hover:bg-primary hover:text-on-primary' : 'bg-error-container text-on-error-container hover:bg-error hover:text-on-error' ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $row['active'] ? 'bg-primary' : 'bg-error' ?>"></span>
                                <?= $row['active'] ? 'Active' : 'Hidden' ?>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant flex-1 line-clamp-2"><?= e($row['intro'] ?: 'No description set.') ?></p>
                <div class="flex items-center justify-between pt-space-sm mt-space-sm border-t border-outline-variant/20">
                    <span class="font-label-sm text-label-sm text-outline">Order: <?= (int)$row['sort_order'] ?></span>
                    <div class="inline-flex items-center gap-1">
                        <a href="?edit=<?= (int)$row['id'] ?>" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </a>
                        <form method="post" onsubmit="return confirm('Delete this service?')" class="inline">
                            <input type="hidden" name="_action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Service Form Drawer -->
<div id="serviceDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-on-surface/40 backdrop-blur-sm" onclick="closeServiceForm()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-xl bg-surface-container-lowest shadow-2xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/30 shrink-0">
            <h2 id="serviceDrawerTitle" class="font-headline-sm text-headline-sm text-on-surface">New Service</h2>
            <button onclick="closeServiceForm()" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form method="post" id="serviceForm" class="flex flex-col flex-1 overflow-y-auto">
            <input type="hidden" name="_action" value="save">
            <input type="hidden" name="id" id="sf-id" value="">
            <div class="p-space-lg space-y-space-md flex-1">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="sf-title">Title <span class="text-error">*</span></label>
                    <input type="text" id="sf-title" name="title" required class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="e.g. AI SEO Optimization">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="sf-slug">Slug</label>
                    <input type="text" id="sf-slug" name="slug" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="ai-seo-optimization">
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="sf-intro">Introduction / Description</label>
                    <textarea id="sf-intro" name="intro" rows="3" class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface resize-none transition-colors" placeholder="Short description of this service..."></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="sf-items">Service Items / Features <span class="font-label-sm text-label-sm text-outline">(JSON or plain list)</span></label>
                    <textarea id="sf-items" name="items" rows="5" class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface font-mono resize-y transition-colors" placeholder='["Keyword Research", "On-page Optimization", "Link Building"]'></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1" for="sf-image">Image URL</label>
                        <input type="text" id="sf-image" name="image" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="/assets/services.avif">
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-1" for="sf-order">Sort Order</label>
                        <input type="number" id="sf-order" name="sort_order" min="0" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="0">
                    </div>
                </div>
                <label class="flex items-center gap-space-sm cursor-pointer select-none">
                    <div class="relative">
                        <input type="checkbox" id="sf-active" name="active" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-surface-container-high rounded-full peer-checked:bg-primary transition-colors"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="font-label-lg text-label-lg text-on-surface">Active (visible on site)</span>
                </label>
            </div>
            <div class="px-space-lg py-space-md border-t border-outline-variant/30 flex justify-end gap-space-sm shrink-0">
                <button type="button" onclick="closeServiceForm()" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">Cancel</button>
                <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Save Service
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const editingService = <?= $editing ? json_encode($editing) : 'null' ?>;

function openServiceForm(data) {
    const drawer = document.getElementById('serviceDrawer');
    if (data) {
        document.getElementById('serviceDrawerTitle').textContent = 'Edit Service';
        document.getElementById('sf-id').value     = data.id;
        document.getElementById('sf-title').value  = data.title || '';
        document.getElementById('sf-slug').value   = data.slug  || '';
        document.getElementById('sf-intro').value  = data.intro || '';
        document.getElementById('sf-items').value  = data.items || '';
        document.getElementById('sf-image').value  = data.image || '';
        document.getElementById('sf-order').value  = data.sort_order ?? 0;
        document.getElementById('sf-active').checked = data.active == 1;
    } else {
        document.getElementById('serviceDrawerTitle').textContent = 'New Service';
        document.getElementById('serviceForm').reset();
        document.getElementById('sf-id').value = '';
    }
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
}
function closeServiceForm() {
    document.getElementById('serviceDrawer').classList.add('hidden');
    document.getElementById('serviceDrawer').classList.remove('flex');
    history.replaceState(null, '', '?');
}
if (editingService) openServiceForm(editingService);

document.getElementById('sf-title').addEventListener('input', function() {
    if (!document.getElementById('sf-id').value) {
        document.getElementById('sf-slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    }
});
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
