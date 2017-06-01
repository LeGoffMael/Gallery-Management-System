<?php
//Connecte le compte
header('Content-Type: application/json');
if (isset($_POST['login_username_mail']) AND isset($_POST['login_password']))
{
	$username_mail = $_POST['login_username_mail'];
	$password = $_POST['login_password'];

	require_once('../Settings.php');

	function combinaison_connexion_valide($username_mail, $password) {

		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idAccount FROM accounts
				WHERE
				(usernameAccount = :username OR
				mailAccount = :mail) AND
				passwordAccount = :password AND
				hashValidationAccount IS NULL");

		$requete->bindValue(':username', $username_mail);
		$requete->bindValue(':mail', $username_mail);
		$requete->bindValue(':password', $password);
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

	$id = combinaison_connexion_valide($username_mail, sha1($password));

	// Si les identifiants sont valides
	if (false !== $id) {
		$infos_utilisateur = lire_infos_utilisateur($id);

		session_start();
		// On enregistre les informations dans la session
		$_SESSION['id'] = $id;
		$_SESSION['user'] = $infos_utilisateur['usernameAccount'];
		$_SESSION['mail'] = $infos_utilisateur['mailAccount'];

		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
	}
	else {
		$error = array("error", "Couple nom d'utilisateur / mot de passe inexistant.");
		echo json_encode($error, JSON_PRETTY_PRINT);
	}
}
else {
	$error = array("error", "Pas de paramètres.");
	echo json_encode($error, JSON_PRETTY_PRINT);
}
?>