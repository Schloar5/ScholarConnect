<?php
require 'includes/db.php';
function deadline_status($deadline){
    if(!$deadline) return ['No deadline','status-neutral',null];
    $today=new DateTimeImmutable('today');
    $d=new DateTimeImmutable($deadline);
    $days=(int)$today->diff($d)->format('%r%a');
    if($days<0) return ['Closed','status-closed',$days];
    if($days<=30) return ['Closing Soon','status-soon',$days];
    return ['Open','status-open',$days];
}
$items=$pdo->query("SELECT id,name,department,category,course,deadline,benefit,official_url FROM scholarships ORDER BY CASE WHEN deadline IS NULL THEN 1 ELSE 0 END, deadline ASC, id DESC")->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Deadline Tracker | ScholarConnect Pro</title><link rel="stylesheet" href="css/style.css"></head><body>
<?php include 'includes/header.php'; ?>
<header class="page-header"><span class="eyebrow">SCHOLARSHIP DEADLINES</span><h1>Deadline Tracker</h1><p>Keep track of scholarship closing dates and focus on opportunities that are still open.</p></header>
<section class="directory deadline-directory">
<div class="deadline-intro"><div><span class="eyebrow">AT A GLANCE</span><h2>Scholarship deadlines</h2><p>Deadlines are calculated automatically from the dates entered by the administrator.</p></div><a class="btn btn-light" href="scholarships.php">Browse Scholarships →</a></div>
<div class="deadline-grid">
<?php foreach($items as $s): $st=deadline_status($s['deadline']); ?>
<article class="deadline-card">
<div class="deadline-card-top"><span class="tag"><?=htmlspecialchars($s['category'])?></span><span class="tag soft"><?=htmlspecialchars($s['course'])?></span><span class="tag <?=$st[1]?>"><?=$st[0]?></span></div>
<h3><?=htmlspecialchars($s['name'])?></h3><p class="department"><?=htmlspecialchars($s['department'])?></p>
<?php if($s['deadline']): ?><div class="deadline-main"><strong><?=htmlspecialchars(date('d M Y',strtotime($s['deadline'])))?></strong><span><?php if($st[2]<0): ?>Deadline passed<?php elseif($st[2]===0): ?>Due today<?php elseif($st[2]===1): ?>1 day remaining<?php else: ?><?=$st[2]?> days remaining<?php endif; ?></span></div><?php else: ?><div class="deadline-main deadline-none"><strong>No deadline entered</strong><span>Check the official portal for current dates.</span></div><?php endif; ?>
<div class="card-actions"><a class="btn btn-small btn-light" href="scholarships.php?id=<?=$s['id']?>">View Details</a><a class="btn btn-small btn-primary" target="_blank" href="<?=htmlspecialchars($s['official_url'] ?? '')?>">Official ↗</a></div>
</article>
<?php endforeach; ?>
</div>
</section><?php include 'includes/footer.php';?></body></html>
