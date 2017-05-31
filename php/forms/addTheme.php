<?php
	// Add a new theme in the database
    header('Content-Type: application/json');
    require_once('../Settings.php');

    if (isset($_POST['nameTheme']) and isset($_POST['mainColor']) and isset($_POST['mainDarkFontColor']) and isset($_POST['bodyColor']) and isset($_POST['bodyFontColor']) and isset($_POST['sideBarColor']) and isset($_POST['sideBarFontColor']) and isset($_POST['linkColor']) and isset($_POST['linkHoverColor']))
    {
		if (!empty($_POST['nameTheme']) and !empty($_POST['mainColor']) and !empty($_POST['mainDarkFontColor']) and !empty($_POST['bodyColor']) and !empty($_POST['bodyFontColor']) and !empty($_POST['sideBarColor']) and !empty($_POST['sideBarFontColor']) and !empty($_POST['linkColor']) and !empty($_POST['linkHoverColor']))
		{

			$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO themes SET
			nameTheme = :nameTheme,
			mainColor = :mainColor,
			mainDarkFontColor = :mainDarkFontColor,
			bodyColor = :bodyColor,
			bodyFontColor = :bodyFontColor,
			sideBarColor = :sideBarColor,
			sideBarFontColor = :sideBarFontColor,
			linkColor = :linkColor,
			linkHoverColor = :linkHoverColor");

			$requete->bindValue(':nameTheme', $_POST['nameTheme']);
			$requete->bindValue(':mainColor', $_POST['mainColor']);
			$requete->bindValue(':mainDarkFontColor', $_POST['mainDarkFontColor']);
			$requete->bindValue(':bodyColor', $_POST['bodyColor']);
			$requete->bindValue(':bodyFontColor', $_POST['bodyFontColor']);
			$requete->bindValue(':sideBarColor', $_POST['sideBarColor']);
			$requete->bindValue(':sideBarFontColor', $_POST['sideBarFontColor']);
			$requete->bindValue(':linkColor', $_POST['linkColor']);
			$requete->bindValue(':linkHoverColor', $_POST['linkHoverColor']);

			if ($requete->execute()) {
				$success = array("success");
				echo json_encode($success, JSON_PRETTY_PRINT);
				exit();
			}
			else {
				$error = array("error" , $requete->errorInfo());
				echo json_encode($error, JSON_PRETTY_PRINT);
				exit();
			}
		}
		else {
			$error = array("error" , "Field(s) are empty.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
	}
	else {
	    $error = array("error" , "Data missing.");
	    echo json_encode($error, JSON_PRETTY_PRINT);
	    exit();
    }
?>