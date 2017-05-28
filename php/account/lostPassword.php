<?php
header('Content-Type: application/json');
if (isset($_POST['lost_mail']))
{
	$mail = $_POST['lost_mail'];

	require_once('../Settings.php');

	function mail_valide($mail) {

		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idAccount FROM accounts WHERE mailAccount = :mail");

		$requete->bindValue(':mail', $mail);
		$requete->execute();

		if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
			$requete->closeCursor();
			return $result['idAccount'];
		}
		return false;
	}

	function lire_infos_utilisateur($idAccount) {

		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT usernameAccount, passwordAccount, mailAccount, dateAccount, hashValidationAccount
				FROM accounts
				WHERE
				idAccount = :idAccount");

		$requete->bindValue(':idAccount', $idAccount);
		$requete->execute();

		if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
			$requete->closeCursor();
			return $result;
		}
		return false;
	}

	function updateAccount($id, $hash) {
		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE accounts SET
		forgetPassAccount = :hash_forget,
		dateLastModificationAccount = NOW()
		WHERE idAccount = :id");

		$requete->bindValue(':hash_forget', $hash);
		$requete->bindValue(':id', $id);
		$requete->execute();
	}

	$id = mail_valide($mail);

	// Si les identifiants sont valides
	if (false !== $id) {
		$hash_forget = md5(uniqid(rand(), true));

		//$hash_forget = 'exemple';

		//On met a jour le compte
		updateAccount($id, $hash_forget);

		$infos_utilisateur = lire_infos_utilisateur($id);

		// Preparation du mail
		$message_mail = '<html><head></head><body>
		<p>Hi '.$infos_utilisateur['usernameAccount'].',<br/>
		You have asked to reset your password. You can now make this change by <a href="'.$_SERVER['HTTP_REFERER'].'../../resetPassword?hash='.$hash_forget.'">clicking here</a>.</p>

		</body>
		<footer style="font-size : 1em;">
		<p>To contact the author : <a href="mailto:legoffmael@gmail.com">legoffmael@gmail.com</a></p>
		</footer></html>';

		$headers_mail  = 'MIME-Version: 1.0'											    ."\r\n";
		$headers_mail .= 'Content-type: text/html; charset=utf-8'					 	    ."\r\n";
		$headers_mail .= 'From: "Gallery Management System" <'.$_SERVER['PHP_SELF'].'>'     ."\r\n";

		// Envoi du mail
		mail($mail, 'Reset password', $message_mail, $headers_mail);

		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
	}
	else {
		$error = array("error", "The e-mail does not match.");
		echo json_encode($error, JSON_PRETTY_PRINT);
	}
}
else {
	$error = array("error", "Pas de paramètre.");
	echo json_encode($error, JSON_PRETTY_PRINT);
}
?>