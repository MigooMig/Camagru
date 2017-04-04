<?php
$DB_DSN = "mysql:host=localhost";
$DB_USER = "root";
$DB_PASSWORD = "root";
$DB_NAME ="42_camagru";

try {
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NAMED);
setup_db($pdo, $DB_NAME);
}
catch(PDOException $e)
{	
	echo $e->getMessage();
}

function setup_db($db, $db_name)
{
	$db->exec("CREATE DATABASE IF NOT EXISTS {$db_name};");
	$db->exec("USE {$db_name};");
	$db->exec("CREATE TABLE IF NOT EXISTS users(
		id INT(11) PRIMARY KEY AUTO_INCREMENT,
		login VARCHAR(255) NOT NULL, 
		mail VARCHAR(255) NOT NULL,
		passwd VARCHAR(255) NOT NULL,
		confirmation_token VARCHAR(60) DEFAULT NULL,
		confirmed_at DATETIME DEFAULT NULL,
		reset_token VARCHAR(60) DEFAULT NULL,
		reset_at DATETIME DEFAULT NULL);");
	$db->exec("CREATE TABLE IF NOT EXISTS images(
		id INT(10) PRIMARY KEY AUTO_INCREMENT,
		user_id INT(10) NOT NULL,
		link VARCHAR(60) NOT NULL, 
		at DATETIME DEFAULT NULL);");
	$db->exec("CREATE TABLE IF NOT EXISTS comments(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
		user_id INT NOT NULL, 
		image_id INT NOT NULL, 
		text_comment VARCHAR(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL);");
	$db->exec("CREATE TABLE IF NOT EXISTS likes(
		id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
		user_id INT NOT NULL, 
		image_id INT NOT NULL);");
}

?>