<?php

if(isset($_GET['id']) && isset($_GET['token'])){
	require 'includes/db.php';
	$request = $pdo->prepare('SELECT * FROM users WHERE id = ? AND token = ? AND reset_at > DATE_SUB(NOW(), INTERVALE 30 MINUTE)');
	$request->execute(array($_GET['id']), array($_GET['token']));
	$user = $request->fetch();
	if($user) {
		debug($user);

	}else {
		$_SESSION['flash']['danger'] = "Ce token n'est pas valide";
		header('Location: login.php');
	}
}else {
	header('Location: login.php');
	exit();
}
?>

<?php require 'includes/header.php'; ?>

<div class="container">
	<form id="contact" action="" method="post">
	<fieldset>
		<input type="password" name="passwd" placeholder='Entrez votre nouveau password' tabindex="1">
	</fieldset>
	<fieldset>
		<input type="password" name="passwd_confirm" placeholder="Confirmation du password" tabindex="2">
	</fieldset>
	<fieldset>
		<button id="contact-submit" type="submit" value="OK" name="submit">Réinitialiser le password</button>
	</fieldset>
	</form>
</div>

<?php require 'includes/footer.php'; ?>