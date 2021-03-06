<?php 
if (session_status() == PHP_SESSION_NONE){
//	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Camagru</title>
	<link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Caesar+Dressing" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="includes/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

		<ul class="topnav">
			<li><a class="active" href="home.php">Accueil</a></li>
			<?php if ($_SESSION['auth'] || isset($_SESSION['auth'])): ?>
				<li><a href="account.php">Mon compte</a></li>
				<li><a href="gallery.php"</li>Gallerie</a></li>	
				<li><a href="logout.php">Logout</a></li>
			<?php else: ?>
				<li><a href="register.php">S'inscrire</a></li>
				<li><a href="login.php">Se Connecter</a></li>
				<li><a href="gallery.php"</li>Gallerie</a></li>
			<?php endif; ?>
		</ul>

<div>

<?php if(isset($_SESSION['flash'])): ?>
	<?php foreach($_SESSION['flash'] as $type => $message): ?>
		<div class="alert <?= $type; ?>">
			<?= $message; ?>
		</div>
	<?php endforeach; ?>
	<?php unset($_SESSION['flash']); ?>
<?php endif; ?>