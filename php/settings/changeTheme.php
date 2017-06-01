<?php
	//Modifie le thème courant dans la base de données
    header('Content-Type: application/json');
    require_once('../Settings.php');

    if (isset($_POST['idTheme']))
    {
		$themes = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT * FROM themes WHERE idTheme = :id");
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
			idTheme = :id");
            $requete->bindValue(':id', $_POST['idTheme']);
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