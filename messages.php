<?php
require_once '../includes/auth.php';adminOnly();require '../includes/db.php';
if(isset($_GET['delete'])){$q=$pdo->prepare('DELETE FROM contact_messages WHERE id=?');$q->execute([(int)$_GET['delete']]);header('Location: messages.php');exit;}
$items=$pdo->query('SELECT * FROM contact_messages ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Messages | ScholarConnect Pro</title><link rel="stylesheet" href="../css/style.css"></head><body>
<?php include '../includes/admin_header.php';?>
<main class="admin-dashboard">
<div class="admin-title"><div><span class="eyebrow">CONTACT MANAGEMENT</span><h1>Contact Messages</h1><p class="muted">Review messages submitted through the ScholarConnect Pro contact form.</p></div></div>
<div class="admin-panel">
<div class="admin-toolbar"><span><b><?=count($items)?></b> message<?=count($items)!==1?'s':''?></span><span class="muted">Newest first</span></div>
<?php if(!$items):?><div class="empty">No messages yet.</div><?php endif;?>
<?php foreach($items as $m):?>
<div class="message-row"><div><b><?=htmlspecialchars($m['subject'])?></b><span><?=htmlspecialchars($m['name'])?> · <?=htmlspecialchars($m['email'])?> · <?=htmlspecialchars($m['created_at'])?></span><p><?=nl2br(htmlspecialchars($m['message']))?></p></div><div class="message-actions"><a class="table-btn danger" onclick="return confirm('Delete this message? This action cannot be undone.')" href="messages.php?delete=<?=$m['id']?>"><span class="icon">⌫</span> Delete</a></div></div>
<?php endforeach;?>
</div></main></body></html>