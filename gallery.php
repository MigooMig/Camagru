<?php

session_start();
require 'includes/db.php';
require 'includes/header.php';

$nb_post = count_post($pdo);
$post_per_page = 6;
	$page = ceil($nb_post/$post_per_page);
if (!isset($_GET['p'])) {
	$page_name = 1;
}
else {
	$page_name = $_GET['p'];
}
if ($current >= 0 && $page_name <= $page){
$current = (($page_name - 1) * $post_per_page);
if (is_numeric($page_name))
{
$req = $pdo->prepare("SELECT id, user_id, link, at FROM images ORDER BY at DESC LIMIT $current, $post_per_page");
$req->execute();
$var = $req->fetchAll(PDO::FETCH_CLASS);
foreach($var as $key => $value) {
	$user = find_user($pdo, $value->user_id);
	$req2 = $pdo->prepare('SELECT id FROM likes WHERE image_id = ? AND user_id = ?');
	$req2->execute(array($value->id, $_SESSION['auth']['id']));
	$on = $req2->fetch();
	print_r('<div class="box_gallery">');
	print_r("<div class='info'>");
	echo "<h4 class='info_user'>$user</h4>";
	print_r("</div>");
	echo "<img id='i{$value->id}' class='picture_size' src='"."{$value->link}"."''>";
	echo "<div class='comment{$value->id} comment'>";
	get_comment($pdo, $value->id);
	echo"</div>";
	if (isset($_SESSION['auth']['id'])) {
	print_r("<div class='interaction'>");
	//	var_dump($on);
	if($on)
	{
		echo "<i id='{$value->id}' class='fa fa-heart heart_s' aria-hidden='true' onclick='likeImg(this.id)' style='margin-left:-5px;margin-top:8px;font-size: 30px;color:red; float: left;'></i>";
	}
	else
	{
		echo "<i id='{$value->id}' class='fa fa-heart-o heart_s' aria-hidden='true' onclick='likeImg(this.id)' style='margin-left:-5px;margin-top:8px;font-size: 30px; float: left;@media screen and (min-width: 200px) and (max-width: 1024px){font-size: 57px;}'></i>";
	}
	echo "<input id='c{$value->id}' class='comment_text' type='text' placeholder='Add comment...' maxlength='1000' autocomplete='off' onkeypress='comment({$value->id})'>";
	print_r('</div>');
	}
	print_r('</div>');
}
}
}
print_r('<div class="box_gallery">');
if ($page != 1){		
	for ($i=1; $i <= $page; $i++) {
		if ($i == $page_name){
			echo "<a style='color:#DC143C;' class='pagination' href='gallery.php?p={$i}'>{$i} </a> ° ";
		}
		else
		{
			echo "<a class='pagination' href='gallery.php?p={$i}'>{$i} </a> ° ";
		}
	}
	}
	print_r('</div>');
?>
<script src="js/gallery.js"></script>
<?php require 'includes/footer.php'; ?>