<?php
require 'includes/db.php';
session_start();
$category=trim($_GET['category']??'');
$course=trim($_GET['course']??'');
$department=trim($_GET['department']??'');
$items=[];
$categories=$pdo->query("SELECT DISTINCT category FROM scholarships WHERE category<>'' ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
$courses=$pdo->query("SELECT DISTINCT course FROM scholarships WHERE course<>'' ORDER BY course")->fetchAll(PDO::FETCH_COLUMN);
$departments=$pdo->query("SELECT DISTINCT department FROM scholarships WHERE department<>'' ORDER BY department")->fetchAll(PDO::FETCH_COLUMN);
if($category||$course||$department){
  $w=[];$p=[];
  if($category){$w[]='category=?';$p[]=$category;}
  if($course){$w[]='course=?';$p[]=$course;}
  if($department){$w[]='department LIKE ?';$p[]='%'.$department.'%';}
  $q=$pdo->prepare('SELECT * FROM scholarships WHERE '.implode(' AND ',$w).' ORDER BY id DESC');$q->execute($p);$items=$q->fetchAll();
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Eligibility Checker | ScholarConnect Pro</title><link rel="stylesheet" href="css/style.css"></head><body><?php include 'includes/header.php';?>
<header class="page-header"><span class="eyebrow">SMART SCHOLARSHIP MATCHING</span><h1>Check Your Eligibility</h1><p>Enter your basic academic details to find scholarship schemes matching the information in our database.</p></header>
<section class="directory eligibility-directory">
  <div class="checker-panel">
    <div class="checker-intro">
      <div class="checker-icon" aria-hidden="true">✓</div>
      <div>
        <span class="checker-kicker">PERSONALISED MATCHING</span>
        <h2>Find scholarships that match you</h2>
        <p>Select one or more criteria below. We'll show matching schemes from the ScholarConnect database.</p>
      </div>
    </div>
    <form class="checker-form" method="get">
      <label>
        <span class="field-title">Category</span>
        <span class="field-help">Your scholarship category</span>
        <span class="select-wrap">
          <select name="category">
            <option value="">All categories</option>
            <?php foreach($categories as $x):?><option value="<?=htmlspecialchars($x)?>" <?=$category===$x?'selected':''?>><?=htmlspecialchars($x)?></option><?php endforeach;?>
          </select>
        </span>
      </label>
      <label>
        <span class="field-title">Course / Level</span>
        <span class="field-help">Your current course</span>
        <span class="select-wrap">
          <select name="course">
            <option value="">All courses / levels</option>
            <?php foreach($courses as $x):?><option value="<?=htmlspecialchars($x)?>" <?=$course===$x?'selected':''?>><?=htmlspecialchars($x)?></option><?php endforeach;?>
          </select>
        </span>
      </label>
      <label>
        <span class="field-title">Department</span>
        <span class="field-help">Your academic department</span>
        <span class="select-wrap">
          <select name="department">
            <option value="">All departments</option>
            <?php foreach($departments as $x):?><option value="<?=htmlspecialchars($x)?>" <?=$department===$x?'selected':''?>><?=htmlspecialchars($x)?></option><?php endforeach;?>
          </select>
        </span>
      </label>
      <div class="checker-actions">
        <button class="btn btn-primary checker-submit" type="submit"><span>Find Matching Scholarships</span><span aria-hidden="true">→</span></button>
        <a class="btn btn-light" href="eligibility.php">Reset</a>
      </div>
    </form>
    <div class="checker-note"><span aria-hidden="true">ⓘ</span> You can select just one criterion or combine all three for a more specific match.</div>
  </div>
<?php if($category||$course||$department):?><div class="results-row"><span><b><?=count($items)?></b> matching scholarship<?=count($items)!==1?'s':''?> found</span><span>Always verify detailed eligibility on the official portal.</span></div><div class="card-grid"><?php foreach($items as $s):?><article class="scholarship-card"><div class="card-top"><span class="tag"><?=htmlspecialchars($s['category'])?></span><span class="tag soft"><?=htmlspecialchars($s['course'])?></span></div><h3><?=htmlspecialchars($s['name'])?></h3><p class="department"><?=htmlspecialchars($s['department'])?></p><p><b>Eligibility</b><br><?=htmlspecialchars($s['eligibility'])?></p><div class="card-actions"><a class="btn btn-small btn-light" href="scholarships.php?id=<?=$s['id']?>">View Details</a><a class="btn btn-small btn-primary" target="_blank" href="<?=htmlspecialchars($s['official_url'])?>">Official ↗</a></div></article><?php endforeach;?></div><?php if(!$items):?><div class="empty">No matching scholarships found. Try changing one of the selections.</div><?php endif;?><?php else:?><div class="empty">Select at least one criterion to check for matching scholarships.</div><?php endif;?></section><?php include 'includes/footer.php';?></body></html>
