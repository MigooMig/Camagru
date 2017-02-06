<?php

function debug($var){
	echo '<pre>' . print_r($var, true) . '</pre>';
}

function str_random($len){
	$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	return substr(str_shuffle(str_repeat($alphabet, $len)), 0, $len);
}

function logged_only(){
	if (session_status() == PHP_SESSION_NONE){
	session_start();
}
	if(!isset($_SESSION['auth'])){
	$_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
	header('Location: login.php');
	exit();
}
}