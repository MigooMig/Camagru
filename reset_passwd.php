<?php

if(isset($_GET['id']) && isset($_GET['token'])){
	require 'includes/db.php';
	require 'includes/functions.php';
	$request = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
	$request->execute(array($_GET['id'], $_GET['token']));
	$user = $request->fetch();
	if($user) {
		if(!empty($_POST)){
			if(!empty($_POST['passwd']) && $_POST['passwd'] == $_POST['passwd_confirm'])
				$password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
				$pdo->prepare('UPDATE users SET passwd = ?, reset_at = NULL, reset_token = NULL')->execute(array($password));
				session_start();
				$_SESSION['flash']['success'] = "Le password est mis à jour";
				$_SESSION['auth'] = $user;
				header('Location: account.php');
				exit();
		}

	}else {
		session_start();
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