<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/config/site.php';
$pdo  = db();
$rows = $pdo->query('SELECT * FROM faqs ORDER BY sort_order ASC, id ASC')->fetchAll();
foreach ($rows as $r) {
    echo $r['id'] . ' | ' . $r['question'] . ' | active=' . $r['active'] . PHP_EOL;
}
echo 'Total: ' . count($rows) . PHP_EOL;
