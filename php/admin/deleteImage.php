<?php
	//Delete an image by this url
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['urlImage'])) {
		$image = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idImage
			FROM images
			WHERE urlImage = :urlImage");
		$image->bindValue(':urlImage', $_POST['urlImage']);
		$image->execute();

		//If no data find
		if($image->rowCount() == 0)
		{
			$error = array("error" , "The Url doesn't exist.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
		else{
			if ($result = $image->fetch(PDO::FETCH_ASSOC)) {
				$image->closeCursor();
			}
			$idImage = $result['idImage'];

			//Delete all references
			$deleteImage = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM images
				WHERE idImage = :idImage");
			$deleteImage->bindValue(':idImage', $idImage);
			$deleteImage->execute();
			$deleteCategories = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM categories_images
				WHERE idImage = :idImage");
			$deleteCategories->bindValue(':idImage', $idImage);
			$deleteCategories->execute();
			$deleteTags = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM tags_images
				WHERE idImage = :idImage");
			$deleteTags->bindValue(':idImage', $idImage);
			$deleteTags->execute();

			//Return success
			$success = array("success");
			echo json_encode($success, JSON_PRETTY_PRINT);
			exit();
		}
	}
	else {
		$error = array("error" , "No datas.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}

?>