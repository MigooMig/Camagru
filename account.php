<?php

session_start();
require 'includes/functions.php';
logged_only();
if(!empty($_POST)){
	if(empty($_POST['passwd']) || $_POST['passwd'] != $_POST['passwd_confirm']) {
		$_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
	}else {
		$user_id = $_SESSION['auth']['id'];
		$password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		require_once 'includes/db.php';
		$pdo->prepare('UPDATE users SET passwd = ?')->execute(array($password));
		$_SESSION['flash']['success'] = "Mise à jour du password";
	}
}
require 'includes/header.php'; 
?>

<h1>Bonjour <?= $_SESSION['auth']['login']; ?></h1>

<div class="container">
	<form id="contact" action="" method="post">
	<fieldset>
		<input type="password" name="passwd" placeholder='Entrez votre nouveau password' tabindex="1">
	</fieldset>
	<fieldset>
		<input type="password" name="passwd_confirm" placeholder="Confirmation du password" tabindex="2">
	</fieldset>
	<fieldset>
		<button id="contact-submit" type="submit" value="OK" name="submit">Modifier votre password</button>
	</fieldset>
	</form>
</div>

<?php require 'includes/footer.php'; ?>