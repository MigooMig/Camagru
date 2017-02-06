<?php
$DB_DSN = "mysql:host=localhost";
$DB_USER = "root";
$DB_PASSWORD = "root";
$DB_NAME ="42_camagru";

try {
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NAMED);
SetupDatabase($pdo, $DB_NAME);
}
catch(PDOException $e)
{	
	echo $e->getMessage();
}

function SetupDatabase($db, $db_name)
{
	$db->exec("CREATE DATABASE IF NOT EXISTS {$db_name};");
	$db->exec("USE {$db_name};");
	$db->exec("CREATE TABLE IF NOT EXISTS users(
		id INT(11) PRIMARY KEY AUTO_INCREMENT,
		login VARCHAR(255) NOT NULL, 
		mail VARCHAR(255) NOT NULL,
		passwd VARCHAR(255) NOT NULL,
		confirmation_token VARCHAR(60) NOT NULL,
		confirmed_at DATETIME DEFAULT NULL,
		reset_token VARCHAR(60) DEFAULT NULL,
		reset_at DATETIME DEFAULT NULL);");
}
?>