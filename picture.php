<?php

session_start();

require_once('config/database.php');

//var_dump($_SESSION);
if($_POST['img'] && $_POST['filter'] && $_SESSION['auth'])
{
	$image = $_POST['img'];
	$filter = $_POST['filter'];
	$image = str_replace('data:image/png;base64,', '', $image);
	$image = str_replace(' ', '+', $image);
	$data = base64_decode($image);
	$today = date("Y-m-d@H:i:s");
	$link = "./tmp/"."{$_SESSION['auth']['login']}"."@"."{$today}".".png";
	file_put_contents($link, $data);

	$source = imagecreatefrompng($filter);
	$largeur_source = imagesx($source);
	$hauteur_source = imagesy($source);
	imagealphablending($source, true);
	imagesavealpha($source, true);
	
if ($destination = imagecreatefrompng($link))
{
	$largeur_destination = imagesx($destination);
	$hauteur_destination = imagesy($destination);
	$destination_x = ($largeur_destination - $largeur_source) / 2;
	$destination_y = ($hauteur_destination - $hauteur_source) / 2;
	imagecopy($destination, $source, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source);
	imagepng($destination, $link);
	imagedestroy($destination);
	imagedestroy($source);
	addImage($pdo, $_SESSION['auth']['id'], $link);
}

}


if($_POST['image_id'])
{
	$req = $pdo->prepare('DELETE FROM images WHERE user_id = ? AND id = ?');
	$req->execute(array($_SESSION['auth']['id'], $_POST['image_id']));
	var_dump($_SESSION);
	var_dump($_POST);
}
/*else {
	echo "IMPOSSIBLE D'ACCEDER A LA PAGE";
}
*/
?>