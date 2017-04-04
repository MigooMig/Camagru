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

function comment_mail($name, $email, $user, $comment)
{ 
	$objet = ''.$user.' vient de mettre un commentaire' ;
	$contenu = '
	<html>
	<head>
		<title>Commentaire Camagru</title>
		<link href="https://fonts.googleapis.com/css?family=Bungee+Shade|Amatic+SC|Cantarell" rel="stylesheet">
	</head>
	<body>
		<h1 style="font-family:Amatic SC;">Hello '.$name.' !</h1>
		<p>'.$user.' vient de commenter votre <a href='.$comment.'>photo</a></p>
		</body>
		</html>';
		$entetes =
		'Content-type: text/html; charset=utf-8' . "\r\n" .
		'From: Camagru@domain.tld' . "\r\n" .
		'Reply-To: Camagru@domain.tld' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		mail($email, $objet, $contenu, $entetes);
}

function addImage($pdo, $id, $link)
{
	$today = date("Y-m-d H:i:s");
	$req = $pdo->prepare("INSERT INTO images SET user_id = ?, link = ?, at = ?");
	$req->execute(array($id, $link, $today));
}

function get_comment($pdo, $image_id)
{
	$req = $pdo->prepare('SELECT user_id, text_comment FROM comments WHERE image_id = ? ORDER BY id DESC');
	$req->execute(array($image_id));
	$var = $req->fetchAll(PDO::FETCH_CLASS);
	if ($var)
	{
		foreach ($var as $key => $value) {
			$user = find_user($pdo, $value->user_id);
			$user = htmlentities($user);
			$comment =htmlentities($value->text_comment);
			echo "<h4 class='com_user'>{$user}</h4><p class='com_text'> {$comment}</p>";
			echo "<br>";
		}
	}
}

function get_page_image($pdo, $image_id)
{
	$req = $pdo->prepare('SELECT id FROM images ORDER BY id DESC');
	$req->execute();
	$findimage = $req->fetchAll();
	$i = 0;
	$array = array();
	foreach ($findimage as $key => $value) {
		$i++;
		if ($value['id'] == $image_id)
		{
			$array['id'] = $i;
		}
	}
	$array['total'] = $i;
	$count = 0;
	$i = $array['id'];
	while ($i > 0) {
		$count++;
		$i = $i - 4;
	}
	return $count;
}


function picture_taken($pdo, $id)
{
	$req = $pdo->prepare('SELECT link FROM images WHERE user_id = ?');
		$req->execute(array($id));
		$var = $req->fetch();
		if ($var['link'])
		{
			return true;
		}
		else
		{
			return false;
		}
}

function get_user_picture($pdo, $id)
{
	$req = $pdo->prepare('SELECT link, id FROM images WHERE user_id = ? ORDER BY id DESC');
	$req->execute(array($id));
	$var = $req->fetchAll();
	foreach ($var as $key => $value) {
		echo "<img id='{$value['id']}' class='img_data' src='{$value['link']}' onclick='delete_picture(this.id)'>";
	}
		//if ($_POST['image_id']) {
		//echo "<p style='font-family:Amatic sc;font-size:30px;'>cliquer sur l'image pour la suprimer</p>";
		//var_dump($_POST['image_id']);
	//}
	// var_dump($var);
}

function find_user($pdo, $id)
{
	$req = $pdo->prepare('SELECT login FROM users WHERE id = ?');
	$req->execute(array($id));
	$user = $req->fetch();
	return $user['login'];
}

function count_like($pdo, $image_id)
{
	$req = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE image_id = ?');
	$req->execute(array($image_id));
	$var = $req->fetch();
	echo $var['COUNT(*)'];
}

function count_post($pdo)
{
	$req = $pdo->prepare('SELECT COUNT(id) as nbpost FROM images');
	$req->execute();
	$var = $req->fetch();
	return $var['nbpost'];
}
?>
