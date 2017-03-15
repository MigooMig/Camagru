<?php
session_start();
require "includes/db.php";
if($_POST['like'])
{
	if ($_POST['like'] == 'true')
	{
		$req = $pdo->prepare('INSERT INTO likes SET 	user_id = ?, image_id = ?');
		$req->execute(array($_SESSION['auth']['id'], $_POST['image_id']));
	}
	if ($_POST['like'] == 'false') 
	{
		$req = $pdo->prepare('DELETE FROM likes WHERE user_id = ? AND image_id = ?');
		$req->execute(array($_SESSION['auth']['id'], $_POST['image_id']));
	}
}
?>