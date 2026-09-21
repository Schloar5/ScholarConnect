<?php
require_once '../includes/auth.php';adminOnly();require '../includes/db.php';
$id=(int)($_GET['id']??0);
$s=['name'=>'','department'=>'','category'=>'SC','course'=>'Post-Matric','eligibility'=>'','benefit'=>'','official_url'=>'https://mahadbt.maharashtra.gov.in/','deadline'=>'','documents'=>''];
if($id){$q=$pdo->prepare('SELECT * FROM scholarships WHERE id=?');$q->execute([$id]);$s=$q->fetch()?:$s;}
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
$v=[];foreach(['name','department','category','course','eligibility','benefit','official_url','deadline','documents'] as $k)$v[$k]=trim($_POST[$k]??'');
if(!$v['name']||!$v['department']||!$v['course']||!$v['eligibility']||!$v['benefit']||!filter_var($v['official_url'],FILTER_VALIDATE_URL))$err='Please complete all fields correctly.';
else{if($id){$q=$pdo->prepare('UPDATE scholarships SET name=?,department=?,category=?,course=?,eligibility=?,benefit=?,official_url=?,deadline=?,documents=? WHERE id=?');$q->execute([...array_values($v),$id]);}else{$q=$pdo->prepare('INSERT INTO scholarships(name,department,category,course,eligibility,benefit,official_url,deadline,documents) VALUES(?,?,?,?,?,?,?,?,?)');$q->execute(array_values($v));}header('Location: scholarships.php');exit;}}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=$id?'Edit':'Add'?> Scholarship | ScholarConnect Pro</title><link rel="stylesheet" href="../css/style.css"></head><body>
<?php include '../includes/admin_header.php';?>
<main class="admin-dashboard">
<div class="admin-title"><div><a class="admin-back" href="scholarships.php">← Back to scholarships</a><span class="eyebrow">SCHOLARSHIP MANAGEMENT</span><h1><?=$id?'Edit':'Add'?> Scholarship</h1><p class="muted"><?=$id?'Update the scholarship information below.':'Create a new scholarship record for students.'?></p></div></div>
<form class="admin-form admin-panel" method="post">
<?php if($err):?><div class="notice full"><?=htmlspecialchars($err)?></div><?php endif;?>
<label>Scholarship Name<input name="name" value="<?=htmlspecialchars($s['name'])?>" placeholder="Enter scholarship name" required></label>
<label>Department<input name="department" value="<?=htmlspecialchars($s['department'])?>" placeholder="e.g. Social Justice Department" required></label>
<label>Category<select name="category"><?php foreach(['SC','ST','OBC','EWS','Minority','Disability','Merit'] as $c):?><option <?=$s['category']===$c?'selected':''?>><?=$c?></option><?php endforeach;?></select></label>
<label>Course / Level<input name="course" value="<?=htmlspecialchars($s['course'])?>" placeholder="e.g. Post-Matric" required></label>
<label class="full">Eligibility<textarea name="eligibility" rows="4" placeholder="Describe who is eligible..." required><?=htmlspecialchars($s['eligibility'])?></textarea></label>
<label class="full">Benefit<textarea name="benefit" rows="3" placeholder="Describe the scholarship benefit..." required><?=htmlspecialchars($s['benefit'])?></textarea></label>
<label>Application Deadline<input type="date" name="deadline" value="<?=htmlspecialchars($s['deadline']??'')?>"></label><label class="full">Required Documents<textarea name="documents" rows="4" placeholder="List required documents, one per line..."><?=htmlspecialchars($s['documents']??'')?></textarea></label><label class="full">Official URL<input type="url" name="official_url" value="<?=htmlspecialchars($s['official_url'])?>" placeholder="https://..." required></label>
<div class="full form-actions"><button class="btn btn-primary" type="submit"><span class="icon">✓</span> <?=$id?'Update':'Save'?> Scholarship</button><a class="btn btn-light" href="scholarships.php">Cancel</a></div>
</form></main></body></html>