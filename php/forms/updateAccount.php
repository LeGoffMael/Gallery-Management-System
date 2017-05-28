<?php
session_start();
header('Content-Type: application/json');
if (isset($_POST['username']) AND isset($_POST['mail']))
{
	if ($_POST['username'] != '' AND $_POST['mail'] != '')
	{
		require_once('../Settings.php');

		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE accounts SET
				usernameAccount = :username,
				mailAccount = :mail,
				dateLastModificationAccount = NOW()
				WHERE idAccount = :id");

		$requete->bindValue(':username', $_POST['username']);
		$requete->bindValue(':mail', $_POST['mail']);
		$requete->bindValue(':id', $_SESSION['id']);
		$requete->execute();

		if (isset($_POST['newPassword']) AND isset($_POST['confirmPassword']))
		{
			if ($_POST['newPassword'] != '' AND $_POST['confirmPassword'] != '')
			{
				if ($_POST['newPassword'] == $_POST['confirmPassword'])
				{
					$newpassword = sha1($_POST['newPassword']);

					$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE accounts SET
					passwordAccount = :password
					dateLastModificationAccount = NOW()
					WHERE idAccount = :id");

					$requete->bindValue(':password', $newpassword);
					$requete->bindValue(':id', $_SESSION['id']);
					$requete->execute();
				}
				else {
					$error = array("error", "Password does not match.");
					echo json_encode($error, JSON_PRETTY_PRINT);
					exit();
				}
			}
		}
		// Suppression de toutes les variables et destruction de la session
		$_SESSION = array();
		session_destroy();
		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
		exit();
	}
	else {
		$error = array("error", "Username and mail can not be empty");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
}
else {
	$error = array("error", "No modification.");
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
?>