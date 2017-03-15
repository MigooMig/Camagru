<?php
session_start();
require "includes/db.php";
var_dump($_POST);
var_dump($_SESSION);
if($_POST['comment'] && $_POST['image_id'])
{
	$req = $pdo->prepare('INSERT INTO comments SET user_id = ?, image_id = ?, text_comment = ?');
	$req->execute(array($_SESSION['auth']['id'], $_POST['image_id'], $_POST['comment']));
	$req = $pdo->prepare('SELECT user_id FROM images WHERE id = ?');
	$req->execute(array($_POST['image_id']));
	$var = $req->fetch();
	if ($_SESSION['id'] != $var['user_id'])
	{
		$req = $pdo->prepare('SELECT login, mail FROM users WHERE id = ?');
		$req->execute(array($var['user_id']));
		$var = $req->fetch();
		$page = get_page_image($pdo, $_POST['image_id']);
		$link = "http://localhost:8080/Camagru/gallery.php?p=".$page."#i".$_POST['image_id'];
		echo $link;	
		comment_mail($var['login'], $var['mail'], $_SESSION['login'], $link);
	}
//	else
//	{
//		echo "this is picture";
//	}
}
?>