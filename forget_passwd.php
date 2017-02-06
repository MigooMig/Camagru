<?php 

require_once 'includes/functions.php';
$mail = $_POST['mail'];
$passwd = $_POST['passwd'];
if(!empty($_POST) && !empty($mail)){
	require_once 'includes/db.php';
	$request = $pdo->prepare('SELECT * FROM users WHERE mail = ? AND confirmed_at IS NOT NULL');
	$request->execute(array($mail));
	$user = $request->fetch();
	if($user){
		session_start();
		$reset_token = str_random(60);
		$pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute(array($reset_token, $user['id']));
		$_SESSION['flash']['success'] = "Envoi du lien de réinitialisation du password";
		mail($_POST['mail'], 'Réinitialisation du password', "Afin de réinitialiser votre password, merci de cliquer sur ce lien\n\nhttp://localhost:8080/Camagru/reset_passwd.php?id=".$user['id']."&token=".$reset_token);
		header('Location: login.php');
		exit();
	}else {
		$_SESSION['flash']['danger'] = "Aucun compte ne correspond à cet email";
	}
}
?>

<?php require 'includes/header.php'; ?>

<h1>Se connecter</h1>

<div class="container">
	<form id="contact" action="" method="post">
		<fieldset>
			<input type="text" name="mail" placeholder='email'>
		</fieldset>
		<fieldset>
			<button id="contact-submit" type="submit" value="OK" name="submit">Sign in</button>
		</fieldset>
		</form>
	</div>

<?php require 'includes/footer.php'; ?>