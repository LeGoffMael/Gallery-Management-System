<?php
	//Modifie le thème courant dans base de données
    header('Content-Type: application/json');
    require_once('../Settings.php');

    if (isset($_POST['idTheme']))
    {

        /* All themes*/
        $this->_themes = array();
		$themes = $this->_database->getDb()->prepare("SELECT * FROM themes WHERE idTheme = :id");
        $themes->bindValue(':id', $_POST['idTheme']);
		$themes->execute();
		if($themes->rowCount() == 0)
		{
            $error = array("error" , "No match.");
            echo json_encode($error, JSON_PRETTY_PRINT);
            exit();
		}
		else{
            Settings::getInstance()->setTheme($_POST['idTheme']);
            $requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE settings SET
				usernameAccount = :username,
				mailAccount = :mail,
				dateLastModificationAccount = NOW()
				WHERE idAccount = :id");

            $requete->bindValue(':username', $_POST['username']);
            $requete->bindValue(':mail', $_POST['mail']);
            $requete->bindValue(':id', $_SESSION['id']);
            $requete->execute();
        }
        $themes->closeCursor();

		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
		exit();

    }
    else {
	    $error = array("error" , "Title Error.");
	    echo json_encode($error, JSON_PRETTY_PRINT);
	    exit();
    }
?>