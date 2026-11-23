<?php
require __DIR__ . '/../_guard.php';
$pdo = admin_db();

// --- Actions ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$pdo) {
        header('Location: ' . admin_url('resources/contact_messages.php'));
        exit;
    }
    $action = $_POST['_action'] ?? '';
    if ($action === 'delete' && !empty($_POST['id'])) {
        $stmt = $pdo->prepare('DELETE FROM contact_messages WHERE id = ?');
        $stmt->execute([(int)$_POST['id']]);
        header('Location: ' . admin_url('resources/contact_messages.php?deleted=1'));
        exit;
    }
}

// --- Category & Search Filters ---
$search = trim($_GET['q'] ?? '');
$cat    = trim($_GET['cat'] ?? 'all');
$page   = max(1, (int)($_GET['p'] ?? 1));
$per    = 15;
$offset = ($page - 1) * $per;

// Metric counts
$total_all     = 0;
$total_careers = 0;
$total_leads   = 0;
$total         = 0;
$rows          = [];

if ($pdo) {
    try {
        $total_all     = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
        $total_careers = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE company LIKE '%Career%'")->fetchColumn();
        $total_leads   = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE company NOT LIKE '%Career%' OR company IS NULL")->fetchColumn();

        $whereClauses = [];
        $params       = [];

        if ($search !== '') {
            $whereClauses[] = '(name LIKE ? OR email LIKE ? OR phone LIKE ? OR company LIKE ? OR message LIKE ?)';
            $like = "%$search%";
            $params = array_merge($params, [$like, $like, $like, $like, $like]);
        }

        if ($cat === 'career') {
            $whereClauses[] = 'company LIKE ?';
            $params[] = '%Career%';
        } elseif ($cat === 'leads') {
            $whereClauses[] = '(company NOT LIKE ? OR company IS NULL)';
            $params[] = '%Career%';
        } elseif ($cat === 'construction') {
            $whereClauses[] = 'company LIKE ?';
            $params[] = '%Construction%';
        } elseif ($cat === 'web') {
            $whereClauses[] = 'company LIKE ?';
            $params[] = '%Web%';
        } elseif ($cat === 'lead_gen') {
            $whereClauses[] = 'company LIKE ?';
            $params[] = '%Lead Generation%';
        }

        $where = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

        $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM contact_messages $where");
        $stmtCount->execute($params);
        $total = (int)$stmtCount->fetchColumn();

        $stmtRows = $pdo->prepare("SELECT * FROM contact_messages $where ORDER BY created_at DESC LIMIT $per OFFSET $offset");
        $stmtRows->execute($params);
        $rows = $stmtRows->fetchAll();
    } catch (Throwable $e) {}
}

$total_pages = max(1, ceil($total / $per));

$page_title = 'Enquiries / Leads';
require __DIR__ . '/../_header.php';
?>

<div class="flex flex-col w-full">

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-space-md mb-space-lg">
        <div class="flex flex-col space-y-1">
            <nav aria-label="Breadcrumbs" class="flex items-center gap-2 text-on-surface-variant">
                <a href="<?= e(admin_url('index.php')) ?>" class="font-label-sm text-label-sm uppercase tracking-wider text-outline hover:text-primary transition-colors">Home</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Enquiries / Leads</span>
            </nav>
            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">Inbound Enquiries &amp; Leads</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">All website contact requests, quote inquiries, and career applications connected directly to the database.</p>
        </div>
        <div class="flex items-center gap-space-sm shrink-0">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container font-label-md text-label-md text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px] text-primary">inbox</span>
                <?= number_format($total_all) ?> total submissions
            </span>
        </div>
    </div>

    <?php if (!empty($_GET['deleted'])): ?>
    <div class="mb-space-md px-space-md py-3 rounded-lg bg-error-container text-on-error-container font-label-md text-label-md flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]">check_circle</span> Enquiry deleted successfully.
    </div>
    <?php endif; ?>

    <!-- Category Filter Tabs & Search Bar -->
    <div class="mb-space-md p-space-md rounded-xl bg-surface-container-lowest shadow-sm flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-space-md">
        
        <!-- Filter Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0">
            <a href="?cat=all<?= $search ? '&q=' . urlencode($search) : '' ?>" 
               class="px-3.5 py-2 rounded-lg font-label-md text-label-md transition-colors shrink-0 <?= $cat === 'all' ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' ?>">
               All (<?= $total_all ?>)
            </a>
            <a href="?cat=leads<?= $search ? '&q=' . urlencode($search) : '' ?>" 
               class="px-3.5 py-2 rounded-lg font-label-md text-label-md transition-colors shrink-0 <?= $cat === 'leads' ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' ?>">
               Client Leads (<?= $total_leads ?>)
            </a>
            <a href="?cat=career<?= $search ? '&q=' . urlencode($search) : '' ?>" 
               class="px-3.5 py-2 rounded-lg font-label-md text-label-md transition-colors shrink-0 <?= $cat === 'career' ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' ?>">
               Careers (<?= $total_careers ?>)
            </a>
            <a href="?cat=construction<?= $search ? '&q=' . urlencode($search) : '' ?>" 
               class="px-3.5 py-2 rounded-lg font-label-md text-label-md transition-colors shrink-0 <?= $cat === 'construction' ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' ?>">
               Construction
            </a>
            <a href="?cat=web<?= $search ? '&q=' . urlencode($search) : '' ?>" 
               class="px-3.5 py-2 rounded-lg font-label-md text-label-md transition-colors shrink-0 <?= $cat === 'web' ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' ?>">
               Web Dev
            </a>
            <a href="?cat=lead_gen<?= $search ? '&q=' . urlencode($search) : '' ?>" 
               class="px-3.5 py-2 rounded-lg font-label-md text-label-md transition-colors shrink-0 <?= $cat === 'lead_gen' ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high' ?>">
               Lead Gen
            </a>
        </div>

        <!-- Search Form -->
        <form method="get" action="" class="flex items-center gap-space-xs shrink-0">
            <input type="hidden" name="cat" value="<?= e($cat) ?>">
            <div class="relative flex-1 sm:w-72">
                <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                <input type="text" name="q" value="<?= e($search) ?>" placeholder="Search name, email, company..." class="w-full h-10 pl-10 pr-4 rounded-lg bg-surface-container-low border border-outline-variant focus:outline-none focus:border-primary font-body-sm text-body-sm text-on-surface placeholder:text-outline transition-colors">
            </div>
            <button type="submit" class="h-10 px-3.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 active:scale-95 transition-all shrink-0">Search</button>
            <?php if ($search): ?>
            <a href="?cat=<?= e($cat) ?>" class="h-10 px-3 rounded-lg bg-surface-container-low text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors flex items-center shrink-0">Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Data Table -->
    <div class="rounded-xl bg-surface-container-lowest shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low text-outline font-label-sm text-label-sm uppercase tracking-wider">
                        <th class="py-3 px-space-md" scope="col">#</th>
                        <th class="py-3 px-space-md" scope="col">Client / Applicant</th>
                        <th class="py-3 px-space-md" scope="col">Category &amp; Source</th>
                        <th class="py-3 px-space-md" scope="col">Contact Info</th>
                        <th class="py-3 px-space-md" scope="col">Message Preview</th>
                        <th class="py-3 px-space-md" scope="col">Submitted</th>
                        <th class="py-3 px-space-md text-right" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody class="font-body-sm text-body-sm divide-y divide-outline-variant/30">
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] text-outline">inbox</span>
                                    <span class="font-body-md text-body-md"><?= $search ? 'No enquiries match your search filter.' : 'No enquiries found in this category.' ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $i => $row):
                            $initials = strtoupper(substr($row['name'], 0, 1) . (strpos($row['name'], ' ') !== false ? substr($row['name'], strpos($row['name'], ' ') + 1, 1) : ''));
                            $colors   = ['bg-primary-container text-on-primary', 'bg-tertiary-container text-on-tertiary', 'bg-secondary-fixed text-on-secondary-fixed'];
                            $color    = $colors[$row['id'] % 3];

                            $companyText = $row['company'] ?? '';
                            $isCareer    = stripos($companyText, 'Career') !== false;
                            $isConstruct = stripos($companyText, 'Construction') !== false;
                            $isWeb       = stripos($companyText, 'Web') !== false;
                            $isLead      = stripos($companyText, 'Lead') !== false;
                            $isSEO       = stripos($companyText, 'SEO') !== false;

                            // Clean phone for whatsapp
                            $cleanPhone = preg_replace('/\D/', '', $row['phone'] ?? '');
                            if (strlen($cleanPhone) === 10) $cleanPhone = '91' . $cleanPhone;
                        ?>
                        <tr class="hover:bg-surface-container-low/70 transition-colors group">
                            <td class="py-3.5 px-space-md text-outline font-label-sm text-label-sm"><?= $offset + $i + 1 ?></td>
                            
                            <!-- Name -->
                            <td class="py-3.5 px-space-md">
                                <div class="flex items-center gap-space-xs">
                                    <div class="w-9 h-9 rounded-full <?= $color ?> font-label-md text-label-md flex items-center justify-center shrink-0 font-bold"><?= $initials ?></div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-label-lg text-label-lg text-on-surface font-semibold truncate"><?= e($row['name']) ?></span>
                                        <span class="text-on-surface-variant font-body-sm text-body-sm truncate"><?= e($row['email']) ?></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Category / Company -->
                            <td class="py-3.5 px-space-md">
                                <div class="flex flex-col gap-1 items-start">
                                    <?php if ($isCareer): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-purple-100 text-purple-700">
                                            <span class="material-symbols-outlined text-[13px]">badge</span> Career
                                        </span>
                                    <?php elseif ($isConstruct): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-amber-100 text-amber-800">
                                            <span class="material-symbols-outlined text-[13px]">construction</span> Construction
                                        </span>
                                    <?php elseif ($isWeb): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-blue-100 text-blue-800">
                                            <span class="material-symbols-outlined text-[13px]">code</span> Web Dev
                                        </span>
                                    <?php elseif ($isLead): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                            <span class="material-symbols-outlined text-[13px]">trending_up</span> Lead Gen
                                        </span>
                                    <?php elseif ($isSEO): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-indigo-100 text-indigo-800">
                                            <span class="material-symbols-outlined text-[13px]">search</span> SEO
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-surface-container-high text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[13px]">mail</span> General Inquiry
                                        </span>
                                    <?php endif; ?>
                                    <span class="font-label-sm text-label-sm text-outline truncate max-w-[180px]"><?= e($companyText ?: 'Direct Website') ?></span>
                                </div>
                            </td>

                            <!-- Contact info -->
                            <td class="py-3.5 px-space-md">
                                <div class="flex flex-col gap-0.5">
                                    <span class="font-label-md text-label-md text-on-surface font-medium"><?= e($row['phone'] ?: 'No Phone') ?></span>
                                    <?php if (!empty($cleanPhone)): ?>
                                        <a href="https://wa.me/<?= e($cleanPhone) ?>?text=<?= urlencode('Hello ' . $row['name'] . ', thank you for contacting TechBound. We received your inquiry regarding ' . ($companyText ?: 'our services') . '.') ?>" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 hover:underline font-semibold">
                                            <span class="material-symbols-outlined text-[13px]">chat</span> Chat WhatsApp
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- Message preview -->
                            <td class="py-3.5 px-space-md max-w-xs">
                                <p class="text-on-surface-variant truncate"><?= e(mb_substr($row['message'], 0, 80)) ?><?= mb_strlen($row['message']) > 80 ? '…' : '' ?></p>
                                <?php if (stripos($row['message'], 'uploads/resumes/') !== false): ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-primary mt-0.5">
                                        <span class="material-symbols-outlined text-[13px]">attach_file</span> Resume Attached
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Date -->
                            <td class="py-3.5 px-space-md text-on-surface whitespace-nowrap font-label-md text-label-md">
                                <?= date('M j, Y', strtotime($row['created_at'])) ?>
                                <span class="block font-label-sm text-label-sm text-outline"><?= date('H:i', strtotime($row['created_at'])) ?></span>
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-space-md text-right">
                                <div class="inline-flex items-center gap-1">
                                    <button onclick="openMessageModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES) ?>)" aria-label="View Full Details" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="View Details">
                                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                                    </button>
                                    
                                    <a href="mailto:<?= e($row['email']) ?>" aria-label="Reply Email" class="w-8 h-8 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" title="Reply via Email">
                                        <span class="material-symbols-outlined text-[18px]">mail</span>
                                    </a>

                                    <?php if (!empty($cleanPhone)): ?>
                                    <a href="https://wa.me/<?= e($cleanPhone) ?>" target="_blank" rel="noopener" aria-label="WhatsApp" class="w-8 h-8 rounded-lg hover:bg-emerald-50 flex items-center justify-center text-emerald-600 transition-colors" title="WhatsApp Message">
                                        <span class="material-symbols-outlined text-[18px]">chat</span>
                                    </a>
                                    <?php endif; ?>

                                    <form method="post" onsubmit="return confirm('Delete this enquiry permanently from the database?')" class="inline">
                                        <input type="hidden" name="_action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                        <button type="submit" aria-label="Delete" class="w-8 h-8 rounded-lg hover:bg-error-container flex items-center justify-center text-on-surface-variant hover:text-error transition-colors" title="Delete">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
        <div class="px-space-md py-3 border-t border-outline-variant/30 flex items-center justify-between">
            <span class="font-body-sm text-body-sm text-on-surface-variant">
                Showing <?= $offset + 1 ?>–<?= min($offset + $per, $total) ?> of <?= $total ?> records
            </span>
            <div class="inline-flex items-center gap-1">
                <?php for ($pg = 1; $pg <= $total_pages; $pg++): ?>
                    <a href="?cat=<?= e($cat) ?>&p=<?= $pg ?><?= $search ? '&q=' . urlencode($search) : '' ?>"
                       class="w-8 h-8 rounded-lg flex items-center justify-center font-label-md text-label-md transition-colors
                              <?= $pg === $page ? 'bg-primary text-on-primary font-semibold' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                        <?= $pg ?>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Message Detail Modal -->
<div id="messageModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-on-surface/40 backdrop-blur-sm">
    <div class="bg-surface-container-lowest rounded-2xl shadow-xl w-full max-w-lg flex flex-col overflow-hidden">
        <div class="flex items-center justify-between px-space-lg py-space-md border-b border-outline-variant/30">
            <h2 class="font-headline-sm text-headline-sm text-on-surface">Enquiry &amp; Lead Details</h2>
            <button onclick="closeMessageModal()" class="w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center text-on-surface-variant transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <div class="p-space-lg space-y-space-md overflow-y-auto max-h-[70vh]">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-space-sm">
                <div>
                    <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-1">Contact Name</p>
                    <p id="modal-name" class="font-label-lg text-label-lg text-on-surface font-semibold"></p>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-1">Company / Role</p>
                    <p id="modal-company" class="font-label-lg text-label-lg text-on-surface"></p>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-1">Email Address</p>
                    <a id="modal-email" href="#" class="font-label-lg text-label-lg text-primary hover:underline truncate block"></a>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-1">Phone Number</p>
                    <p id="modal-phone" class="font-label-lg text-label-lg text-on-surface"></p>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-1">Date Received</p>
                    <p id="modal-date" class="font-label-lg text-label-lg text-on-surface"></p>
                </div>
                <div>
                    <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-1">IP Address</p>
                    <p id="modal-ip" class="font-label-lg text-label-lg text-outline"></p>
                </div>
            </div>

            <!-- Resume attachment banner if found in message -->
            <div id="modal-resume-wrap" class="hidden p-3 rounded-lg bg-primary-container/20 border border-primary/30 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <span class="font-label-md text-label-md text-on-surface font-semibold">Attached Resume / CV</span>
                </div>
                <a id="modal-resume-btn" href="#" target="_blank" download class="px-3 py-1.5 rounded-lg bg-primary text-on-primary font-label-sm text-label-sm flex items-center gap-1 hover:opacity-90 transition-opacity">
                    <span class="material-symbols-outlined text-[15px]">download</span> Download File
                </a>
            </div>

            <div>
                <p class="font-label-sm text-label-sm text-outline uppercase tracking-wider mb-2">Full Message &amp; Details</p>
                <div id="modal-message" class="p-space-md rounded-lg bg-surface-container-low font-body-md text-body-md text-on-surface whitespace-pre-wrap leading-relaxed"></div>
            </div>
        </div>
        <div class="px-space-lg py-space-md border-t border-outline-variant/30 flex items-center justify-between">
            <button onclick="closeMessageModal()" class="h-9 px-space-md rounded-lg bg-surface-container-low text-on-surface font-label-lg text-label-lg hover:bg-surface-container-high transition-colors">Close</button>
            <div class="flex items-center gap-space-xs">
                <a id="modal-wa-btn" href="#" target="_blank" rel="noopener" class="h-9 px-space-md rounded-lg bg-emerald-600 text-white font-label-md text-label-md shadow-sm hover:bg-emerald-700 transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">chat</span> WhatsApp
                </a>
                <a id="modal-reply-btn" href="#" class="h-9 px-space-md rounded-lg bg-primary text-on-primary font-label-md text-label-md shadow-sm hover:opacity-90 transition-colors flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">mail</span> Email Reply
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openMessageModal(row) {
    document.getElementById('modal-name').textContent    = row.name || '—';
    document.getElementById('modal-company').textContent = row.company || 'Direct Website';
    document.getElementById('modal-phone').textContent   = row.phone || '—';
    document.getElementById('modal-message').textContent = row.message || '—';
    document.getElementById('modal-date').textContent    = row.created_at || '—';
    document.getElementById('modal-ip').textContent      = row.ip || '—';

    const emailEl = document.getElementById('modal-email');
    emailEl.textContent = row.email || '—';
    emailEl.href = 'mailto:' + (row.email || '');
    document.getElementById('modal-reply-btn').href = 'mailto:' + (row.email || '');

    // WhatsApp action
    const waBtn = document.getElementById('modal-wa-btn');
    let phoneDigits = (row.phone || '').replace(/\D/g, '');
    if (phoneDigits) {
        if (phoneDigits.length === 10) phoneDigits = '91' + phoneDigits;
        waBtn.href = 'https://wa.me/' + phoneDigits;
        waBtn.style.display = 'inline-flex';
    } else {
        waBtn.style.display = 'none';
    }

    // Check for resume path in message
    const resumeWrap = document.getElementById('modal-resume-wrap');
    const resumeBtn  = document.getElementById('modal-resume-btn');
    const resumeMatch = (row.message || '').match(/uploads\/resumes\/[a-zA-Z0-9_\-\.]+/);
    if (resumeMatch) {
        resumeBtn.href = '../../' + resumeMatch[0];
        resumeWrap.classList.remove('hidden');
    } else {
        resumeWrap.classList.add('hidden');
    }

    const modal = document.getElementById('messageModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeMessageModal() {
    const modal = document.getElementById('messageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('messageModal').addEventListener('click', function(e) {
    if (e.target === this) closeMessageModal();
});
</script>

<?php require __DIR__ . '/../_footer.php'; ?>
