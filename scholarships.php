<?php
require_once '../includes/auth.php';adminOnly();require '../includes/db.php';
if(isset($_GET['delete'])){$q=$pdo->prepare('DELETE FROM scholarships WHERE id=?');$q->execute([(int)$_GET['delete']]);header('Location: scholarships.php');exit;}
$search=trim($_GET['search']??'');
if($search){$q=$pdo->prepare('SELECT * FROM scholarships WHERE name LIKE ? OR category LIKE ? OR course LIKE ? OR department LIKE ? ORDER BY id DESC');$x="%$search%";$q->execute([$x,$x,$x,$x]);$items=$q->fetchAll();}else{$items=$pdo->query('SELECT * FROM scholarships ORDER BY id DESC')->fetchAll();}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Manage Scholarships | ScholarConnect Pro</title><link rel="stylesheet" href="../css/style.css"></head><body>
<?php include '../includes/admin_header.php';?>
<main class="admin-dashboard">
<div class="admin-title"><div><span class="eyebrow">SCHOLARSHIP MANAGEMENT</span><h1>Scholarships</h1><p class="muted">Add, update or remove scholarship records from the database.</p></div><a class="btn btn-primary" href="scholarship-form.php"><span class="icon">＋</span> Add Scholarship</a></div>
<div class="admin-panel">
<div class="admin-toolbar"><form class="admin-search" method="get"><input name="search" value="<?=htmlspecialchars($search)?>" placeholder="Search scholarships..."></form><span class="muted"><?=count($items)?> record<?=count($items)!==1?'s':''?></span></div>
<div class="record-list">
<div class="record-head"><span>Scholarship details</span><span>Actions</span></div>
<?php if(!$items):?><div class="empty">No scholarships found<?= $search ? ' for “'.htmlspecialchars($search).'”' : '' ?>.</div><?php endif;?>
<?php foreach($items as $x):?>
<div class="admin-row">
<div><b><?=htmlspecialchars($x['name'])?></b><span><?=htmlspecialchars($x['category'])?> · <?=htmlspecialchars($x['course'])?> · <?=htmlspecialchars($x['department'])?><?=!empty($x['deadline'])?' · Deadline: '.htmlspecialchars($x['deadline']):' · Deadline not set'?></span></div>
<div class="action-group">
<a class="table-btn" href="scholarship-form.php?id=<?=$x['id']?>" title="Edit scholarship"><span class="icon">✎</span> Edit</a>
<a class="table-btn danger" onclick="return confirm('Delete this scholarship? This action cannot be undone.')" href="scholarships.php?delete=<?=$x['id']?>" title="Delete scholarship"><span class="icon">⌫</span> Delete</a>
</div>
</div>
<?php endforeach;?>
</div></div></main></body></html>