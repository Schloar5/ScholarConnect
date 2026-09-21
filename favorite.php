<?php
require 'includes/db.php';
session_start();
if(empty($_SESSION['student_id'])){header('Location: login.php?login_required=1');exit;}
$id=(int)($_GET['id']??0);$back=$_GET['back']??'scholarships.php';
if($id){$q=$pdo->prepare('SELECT id FROM scholarships WHERE id=?');$q->execute([$id]);if($q->fetch()){ $q=$pdo->prepare('SELECT id FROM student_favourites WHERE student_id=? AND scholarship_id=?');$q->execute([$_SESSION['student_id'],$id]); if($q->fetch()){$pdo->prepare('DELETE FROM student_favourites WHERE student_id=? AND scholarship_id=?')->execute([$_SESSION['student_id'],$id]);}else{$pdo->prepare('INSERT IGNORE INTO student_favourites(student_id,scholarship_id) VALUES(?,?)')->execute([$_SESSION['student_id'],$id]);}}}
if(strpos($back,'://')!==false || strpos($back,'\n')!==false || strpos($back,'\r')!==false) $back='scholarships.php';
header('Location: '.$back);exit;
