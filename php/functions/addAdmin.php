<?php
header('Content-Type: application/json');
if (isset($_POST['mail']))
{
	$mail = $_POST['mail'];

	require_once('../Settings.php');

	function addNewAccount($mail, $hash_validation) {

		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO accounts SET
		mailAccount = :mail,
		hashValidationAccount = :hashValidation,
		dateAccount = NOW(),
		dateLastModificationAccount = NOW()");

		$requete->bindValue(':mail',   $mail);
		$requete->bindValue(':hashValidation', $hash_validation);

		if ($requete->execute()) {
			return Settings::getInstance()->getDatabase()->getDb()->lastInsertId();
		}
		return $requete->errorInfo();
	}

	$hash_validation = md5(uniqid(rand(), true));

	$id = addNewAccount($mail, $hash_validation);

	// Si la base de données a bien voulu ajouter l'utilisateur (pas de doublons)
	if (ctype_digit($id)) {

		// On transforme la chaine en entier
		$id = (int) $id;

		// Preparation du mail
		$message_mail = '<html><head></head><body>
		<p>Congratulations !<br/>
		You have been prompted to create your administrator account. You can do it now by <a href="'.$_SERVER['HTTP_REFERER'].'../../newAdmin?hash='.$hash_validation.'">clicking here</a>.</p>

		</body>
		<footer style="font-size : 1em;">
		<p>To contact the author : <a href="mailto:legoffmael@gmail.com">legoffmael@gmail.com</a></p>
		</footer></html>';

		$headers_mail  = 'MIME-Version: 1.0'                           ."\r\n";
		$headers_mail .= 'Content-type: text/html; charset=utf-8'      ."\r\n";
		$headers_mail .= 'From: "Gallery Management System" <'.$_SERVER['PHP_SELF'].'>'     ."\r\n";

		// Envoi du mail
		mail($mail, 'Create your administrator account', $message_mail, $headers_mail);

		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
		exit();
	// Gestion des doublons
	}
	else {
		// Changement de nom de variable (plus lisible)
		$erreur =& $id;

		// On vérifie que l'erreur concerne bien un doublon
		if (23000 == $erreur[0]) { // Le code d'erreur 23000 siginife "doublon" dans le standard ANSI SQL
			$error = array("error", "This email address is already  use.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
		else {
			$error = array("error", sprintf("Error adding SQL: untreated case (SQLSTATE = %d).", $erreur[0]));
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
	}
}
else {
	$error = array("error", "No email address.");
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
?>