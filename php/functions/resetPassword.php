<?php
header('Content-Type: application/json');
if (isset($_POST['hash']) AND isset($_POST['newPassword']) AND isset($_POST['confirmPassword']))
{
	if (($_POST['hash']) != '')
	{
		if ($_POST['newPassword'] == $_POST['confirmPassword'])
		{
			$hash = $_POST['hash'];
			$password = $_POST['newPassword'];

			require_once('../Settings.php');

			function hash_valide($hash) {

				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idAccount FROM accounts WHERE forgetPassAccount = :hash");

				$requete->bindValue(':hash', $hash);
				$requete->execute();

				if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
					$requete->closeCursor();
					return $result['idAccount'];
				}
				return false;
			}

			function lire_infos_utilisateur($idAccount) {

				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT usernameAccount, mailAccount, dateAccount, hashValidationAccount
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

			function updateAccount($id, $password) {
				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE accounts SET
				passwordAccount = :password,
				forgetPassAccount = '',
				dateLastModificationAccount = NOW()
				WHERE idAccount = :id");

				$requete->bindValue(':password', $password);
				$requete->bindValue(':id', $id);
				$requete->execute();
			}

			$id = hash_valide($hash);

			// Si le hash est valide
			if (false !== $id) {
				$newpassword = sha1($password);

				//On met a jour le compte
				updateAccount($id, $newpassword);

				$infos_utilisateur = lire_infos_utilisateur($id);
				$mail = $infos_utilisateur['mailAccount'];

				// Preparation du mail
				$message_mail = '<html><head></head><body>
				<p>Hello again '.$infos_utilisateur['usernameAccount'].',<br/>
				Your password has been reset successfully.</p>

				</body>
				<footer style="font-size : 1em;">
				<p>To contact the author : <a href="mailto:legoffmael@gmail.com">legoffmael@gmail.com</a></p>
				</footer></html>';

				$headers_mail  = 'MIME-Version: 1.0'											    ."\r\n";
				$headers_mail .= 'Content-type: text/html; charset=utf-8'					 	    ."\r\n";
				$headers_mail .= 'From: "Gallery-Management-System" <'.$_SERVER['PHP_SELF'].'>'     ."\r\n";

				// Envoi du mail
				mail($mail, 'Password reset confirmation', $message_mail, $headers_mail);

				session_start();
				// Suppression de toutes les variables et destruction de la session
				$_SESSION = array();
				session_destroy();

				$success = array("success");
				echo json_encode($success, JSON_PRETTY_PRINT);
			}
			else {
				$error = array("error", "Hash does not exist.");
				echo json_encode($error, JSON_PRETTY_PRINT);
				exit();
			}
		}
		else {
			$error = array("error", "Not same password.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
	}
	else {
		$error = array("error", "Hash is empty.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
}
else {
	$error = array("error", "No datas.");
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
?>