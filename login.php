<?php 

require_once 'includes/functions.php';
$login = $_POST['login'];
$passwd = $_POST['passwd'];
if(!empty($_POST) && !empty($login) && !empty($passwd)){
	require_once 'includes/db.php';
	$request = $pdo->prepare('SELECT * FROM users WHERE login = :login AND confirmed_at IS NOT NULL');
	$request->execute(['login' => $login]);
	$user = $request->fetch();
	if(password_verify($passwd, $user['passwd'])){
		session_start();
		$_SESSION['auth'] = $user;
		$_SESSION['flash']['success'] = "Vous êtes connecté";
		header('Location: account.php');
		exit();
	}else {
		$_SESSION['flash']['danger'] = "Login ou password incorrect";
	}
}
?>

<?php require 'includes/header.php'; ?>

<h1>Se connecter</h1>

<div class="container">
	<form id="contact" action="" method="post">
		<fieldset>
			<input type="text" name="login" placeholder='Login' tabindex="1">
		</fieldset>
		<fieldset>
			<input type="password" name="passwd" placeholder="Password" tabindex="4">
		</fieldset>
		<fieldset>
			<button id="contact-submit" type="submit" value="OK" name="submit">Sign in</button>
		</fieldset>
		<a href="forget_passwd.php">Password oublié</a>
		</form>
	</div>

<?php require 'includes/footer.php'; ?>