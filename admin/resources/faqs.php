<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();

$action = $_POST['_action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . admin_url('resources/faqs.php?flash=' . urlencode('error:Cannot modify FAQs while database is disconnected.')));
        exit;
    }
    if ($action === 'save') {
        $id         = (int)($_POST['id'] ?? 0);
        $question   = trim($_POST['question']   ?? '');
        $answer     = trim($_POST['answer']     ?? '');
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $active     = isset($_POST['active']) ? 1 : 0;

        if ($question === '' || $answer === '') {
            $flash = 'error:Question and Answer are required.';
        } else {
            if ($id) {
                $pdo->prepare('UPDATE faqs SET question=?,answer=?,sort_order=?,active=? WHERE id=?')
                    ->execute([$question, $answer, $sort_order, $active, $id]);
                $flash = 'success:FAQ updated.';
            } else {
                $pdo->prepare('INSERT INTO faqs (question,answer,sort_order,active) VALUES (?,?,?,?)')
                    ->execute([$question, $answer, $sort_order, $active]);
                $flash = 'success:FAQ added.';
            }
            header('Location: ' . admin_url('resources/faqs.php?flash=' . urlencode($flash)));
            exit;
        }
    }
    if ($action === 'delete' && !empty($_POST['id'])) {
        $pdo->prepare('DELETE FROM faqs WHERE id=?')->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/faqs.php?flash=' . urlencode('success:FAQ deleted.')));
        exit;
    }
    if ($action === 'toggle' && !empty($_POST['id'])) {
        $pdo->prepare('UPDATE faqs SET active = 1 - active WHERE id=?')->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/faqs.php'));
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
            $s = $pdo->prepare('SELECT * FROM faqs WHERE id=?');
            $s->execute([(int)$_GET['edit']]);
            $editing = $s->fetch();
        }

        $search = trim($_GET['q'] ?? '');
        $where  = $search !== '' ? 'WHERE question LIKE ? OR answer LIKE ?' : '';
        $params = $search !== '' ? ["%$search%", "%$search%"] : [];

        $stmtC = $pdo->prepare("SELECT COUNT(*) FROM faqs $where");
        $stmtC->execute($params);
        $total = (int)$stmtC->fetchColumn();

        $stmtR = $pdo->prepare("SELECT * FROM faqs $where ORDER BY sort_order ASC, id ASC");
        $stmtR->execute($params);
        $rows = $stmtR->fetchAll();

        $active_count = count(array_filter($rows, fn($r) => $r['active']));
    } catch (Throwable $e) {}
}

$page_title = 'FAQs Manager';
require __DIR__ . '/../_header.php';
?>

<div class="flex flex-col w-full">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">FAQs Manager</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">FAQs Manager</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Manage frequently asked questions shown on the website</p>
        </div>
        <div class="flex items-center gap-space-sm shrink-0">
            <div class="flex items-center gap-space-xs px-3 py-1.5 rounded-lg bg-surface-container font-label-md text-label-md text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary">quiz</span>
                <span><?= $active_count ?> active</span>
                <span class="text-outline">/ <?= $total ?> total</span>
            </div>
            <button onclick="openFaqForm()" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-md hover:opacity-95 active:scale-95 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span> Add FAQ
            </button>
        </div>
    </div>

    <?php if ($flash_msg): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg <?= $flash_type === 'success' ? 'bg-surface-container-high text-primary' : 'bg-error-container text-on-error-container' ?> font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]"><?= $flash_type === 'success' ? 'check_circle' : 'error' ?></span> <?= e($flash_msg) ?>
    </div>
    <?php endif; ?>

    <!-- Search -->
    <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex items-center gap-space-sm">
        <form method="get" class="flex flex-1 items-center gap-space-sm">
            <div class="relative flex-1 max-w-md">
                <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search questions and answers..." class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface placeholder:text-outline transition-colors">
            </div>
            <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 transition-all shrink-0">Search</button>
            <?php if ($search): ?><a href="?" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface-variant font-label-lg text-label-lg hover:bg-surface-container-high transition-colors flex items-center shrink-0">Clear</a><?php endif; ?>
        </form>
    </div>

    <!-- FAQ Accordion-style Table -->
    <?php if (empty($rows)): ?>
    <div class="rounded-xl bg-surface-container-lowest shadow-sm py-16 flex flex-col items-center gap-4 text-on-surface-variant">
        <span class="material-symbols-outlined text-[48px] text-outline">quiz</span>
        <span class="font-body-md text-body-md"><?= $search ? 'No FAQs match your search.' : 'No FAQs yet. Add your first one!' ?></span>
        <?php if (!$search): ?><button onclick="openFaqForm()" class="h-9 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg">Add FAQ</button><?php endif; ?>
    </div>
    <?php else: ?>
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden divide-y divide-outline-variant/30">
        <?php foreach ($rows as $i => $row): ?>
        <div class="flex items-start gap-space-sm p-space-md hover:bg-surface-container-low/50 transition-colors group <?= !$row['active'] ? 'opacity-60' : '' ?>">
            <!-- Order badge -->
            <div class="w-7 h-7 rounded-full bg-surface-container text-outline font-label-sm text-label-sm flex items-center justify-center shrink-0 mt-0.5"><?= $i + 1 ?></div>
            <!-- Content -->
            <div class="flex flex-col flex-1 min-w-0">
                <p class="font-label-lg text-label-lg text-on-surface font-semibold"><?= e($row['question']) ?></p>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 leading-relaxed line-clamp-2"><?= e($row['answer']) ?></p>
            </div>
            <!-- Actions -->
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
                <form method="post" onsubmit="return confirm('Delete this FAQ?')" class="inline">
                    <input type="hidden" name="_action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                    <button type="submit" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- FAQ Form Drawer -->
<div id="faqDrawer" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-on-surface/40 backdrop-blur-sm" onclick="closeFaqForm()"></div>
    <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-surface-container-lowest shadow-2xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/30 shrink-0">
            <h2 id="faqDrawerTitle" class="font-headline-sm text-headline-sm text-on-surface">Add FAQ</h2>
            <button onclick="closeFaqForm()" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form method="post" id="faqForm" class="flex flex-col flex-1 overflow-y-auto">
            <input type="hidden" name="_action" value="save">
            <input type="hidden" name="id" id="ff-id" value="">
            <div class="p-space-lg space-y-space-md flex-1">
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-question">Question <span class="text-error">*</span></label>
                    <textarea id="ff-question" name="question" rows="3" required class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface resize-none transition-colors" placeholder="e.g. What services does TechBound offer?"></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-answer">Answer <span class="text-error">*</span></label>
                    <textarea id="ff-answer" name="answer" rows="6" required class="w-full px-space-sm py-2 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface resize-y transition-colors" placeholder="Provide a clear and helpful answer..."></textarea>
                </div>
                <div>
                    <label class="block font-label-md text-label-md text-on-surface mb-1" for="ff-order">Sort Order</label>
                    <input type="number" id="ff-order" name="sort_order" min="0" value="0" class="w-full h-10 px-space-sm rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-md text-body-md text-on-surface transition-colors">
                </div>
                <label class="flex items-center gap-space-sm cursor-pointer select-none">
                    <div class="relative">
                        <input type="checkbox" id="ff-active" name="active" value="1" class="sr-only peer" checked>
                        <div class="w-10 h-6 bg-surface-container-high rounded-full peer-checked:bg-primary transition-colors"></div>
                        <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                    </div>
                    <span class="font-label-lg text-label-lg text-on-surface">Active (visible on site)</span>
                </label>
            </div>
            <div class="px-space-lg py-space-md border-t border-outline-variant/30 flex justify-end gap-space-sm shrink-0">
                <button type="button" onclick="closeFaqForm()" class="h-10 px-space-md rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">Cancel</button>
                <button type="submit" class="h-10 px-space-md rounded-lg bg-primary text-on-primary font-label-lg text-label-lg shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Save FAQ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const editingFaq = <?= $editing ? json_encode($editing) : 'null' ?>;

function openFaqForm(data) {
    const drawer = document.getElementById('faqDrawer');
    if (data) {
        document.getElementById('faqDrawerTitle').textContent = 'Edit FAQ';
        document.getElementById('ff-id').value       = data.id;
        document.getElementById('ff-question').value = data.question || '';
        document.getElementById('ff-answer').value   = data.answer   || '';
        document.getElementById('ff-order').value    = data.sort_order ?? 0;
        document.getElementById('ff-active').checked = data.active == 1;
    } else {
        document.getElementById('faqDrawerTitle').textContent = 'Add FAQ';
        document.getElementById('faqForm').reset();
        document.getElementById('ff-id').value = '';
    }
    drawer.classList.remove('hidden');
    drawer.classList.add('flex');
}
function closeFaqForm() {
    document.getElementById('faqDrawer').classList.add('hidden');
    document.getElementById('faqDrawer').classList.remove('flex');
    history.replaceState(null, '', '?');
}
if (editingFaq) openFaqForm(editingFaq);
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
