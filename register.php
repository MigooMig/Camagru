<?php
session_start();
require_once 'includes/functions.php';
if (!empty($_POST)) {
	$errors = array();
 	require_once 'includes/db.php';
	if(empty($_POST['login']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['login']) || strlen($_POST['login']) <= 2){
			$errors['login'] = "Le login n'est pas valide";
	} else {
		$request = $pdo->prepare('SELECT id FROM users WHERE login = ?');
		$request->execute(array($_POST['login']));
		$user = $request->fetch();
		
		if($user){
			$errors['login'] = 'ce login est dèjà utilisé.';
		}
	}

	if(empty($_POST['mail']) || !filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		$errors['mail'] = "Votre email n'est pas valide";
	} else {
		$request = $pdo->prepare('SELECT id FROM users WHERE mail = ?');
		$request->execute(array($_POST['mail']));
		$user = $request->fetch();
		
		if($user){
			$errors['mail'] = 'cet email est dèjà utilisé.';
		}
	}
	if(empty($_POST['passwd']) || $_POST['passwd'] != $_POST['passwd_confirm']){
		$errors['passwd'] = "Votre mot de passe n'est pas valide";
	}

	if(empty($errors)){
		$request = $pdo->prepare("INSERT INTO users SET login = ?, passwd = ?, mail = ?, confirmation_token = ?");
		$password = password_hash($_POST['passwd'], PASSWORD_BCRYPT);
		$token = str_random(60);
		$request->execute([$_POST['login'], $password, $_POST['mail'], $token]);
		$user_id = $pdo->lastInsertId();
		mail($_POST['mail'], 'Confirmation de votre compte', "Afin de finaliser votre inscription, merci de cliquer sur ce lien\n\nhttp://localhost:8080/Camagru/confirm.php?id=".$user_id."&token=".$token);
		$_SESSION['flash']['success'] = "un email de confirmation a été envoyé afin de valider votre compte";
		header('Location: login.php');
		exit();
	}
}
?>
<?php require 'includes/header.php'; ?>
<?php if(!empty($errors)){
echo  "<div class='alert'>
	<h2>Vous n'avez pas rempli le formulaire correctement</h2>
	<ul>";
		foreach($errors as $error){
			echo "<li>$error;</li>";
		}
	echo "</ul>
</div>";
}
?>
<div class="container">
	<form id="contact" action="" method="post">
		<fieldset>
			<input type="text" name="login" placeholder='Login' tabindex="1">
		</fieldset>
		<fieldset>
			<input type="text" name="mail" placeholder="email" tabindex="2">
		</fieldset>
		<fieldset>
			<input type="password" name="passwd" placeholder='Password' tabindex="3">
		</fieldset>
		<fieldset>
			<input type="password" name="passwd_confirm" placeholder="Confirm Password" tabindex="4">
		</fieldset>
		<fieldset>
			<button id="contact-submit" type="submit" value="OK" name="submit">Create an Account</button>
		</fieldset>
		</form>
	</div>

<?php require 'includes/footer.php'; ?>