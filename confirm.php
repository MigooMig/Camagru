<?php

session_start();
$user_id = $_GET['id'];
$token = $_GET['token'];
require 'config/database.php';
$request = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$request->execute(array($user_id));
$user = $request->fetch();

if($user && $user['confirmation_token'] == $token) {
	$request = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute(array($user_id));
	$_SESSION['flash']['success'] = "Votre compte a bien été validé";
	$_SESSION['auth'] = $user;
	header('Location: account.php');
}
else {
	$_SESSION['flash']['danger'] = "Ce token n'est plus valide";
	header('Location: login.php');
}
?>