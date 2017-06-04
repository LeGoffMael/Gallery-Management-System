<?php
	//Edit an image by this url
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['urlImage']) and isset($_POST['descriptionImage']) and isset($_POST['tabCategories']) and isset($_POST['tabTags'])) {

		$image = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idImage
			FROM images
			WHERE urlImage = :urlImage");
		$image->bindValue(':urlImage', $_POST['urlImage']);
		$image->execute();

		$tabCategories = json_decode($_POST["tabCategories"]);
		$tabTags = json_decode($_POST["tabTags"]);

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

			$categories_exist = array();
			if(!empty($tabCategories)) {
				foreach($tabCategories as $id){
					$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory
						FROM categories
						WHERE idCategory = :id");
					$categories->bindValue(':id', $id);
					$categories->execute();

					if($categories->rowCount() != 0) {
						if ($result = $categories->fetch(PDO::FETCH_ASSOC)) {
							$categories->closeCursor();
						}
						array_push($categories_exist, $result['idCategory']);
					}
				}
			}
			//If there are corresponding categories
			if (!empty($categories_exist)) {
				$tags_exist = array();
				//Check tags which exist
				if(!empty($tabTags)) {
					foreach($tabTags as $id){
						$tags = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idTag
							FROM tags
							WHERE idTag = :id");
						$tags->bindValue(':id', $id);
						$tags->execute();

						if($tags->rowCount() != 0) {
							if ($result = $tags->fetch(PDO::FETCH_ASSOC)) {
								$tags->closeCursor();
							}
							array_push($tags_exist, $result['idTag']);
						}
					}
				}

				//Update the image
				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE images
					SET descriptionImage = :description
					WHERE idImage = :id");

				$requete->bindValue(':description', $_POST['descriptionImage']);
				$requete->bindValue(':id', $idImage);

				//If update working
				if ($requete->execute()) {
					//Delete previous link
					$deleteCategories = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM categories_images
						WHERE idImage = :idImage");
					$deleteCategories->bindValue(':idImage', $idImage);
					$deleteCategories->execute();
					$deleteTags = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM tags_images
						WHERE idImage = :idImage");
					$deleteTags->bindValue(':idImage', $idImage);
					$deleteTags->execute();

					//Link all categories with the image
					foreach ($categories_exist as $value){
						$requete2 = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO categories_images SET
							idCategory = :idCategory,
							idImage = :idImage");

						$requete2->bindValue(':idCategory', $value);
						$requete2->bindValue(':idImage', $idImage);
						$requete2->execute();
					}

					//Link all tags with the image
					if(!empty($tags_exist)) {
						foreach ($tags_exist as $value){
							$requete3 = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO tags_images SET
								idTag = :idTag,
								idImage = :idImage");

							$requete3->bindValue(':idTag', $value);
							$requete3->bindValue(':idImage', $idImage);
							$requete3->execute();
						}
					}

					$error = array("success");
					echo json_encode($error, JSON_PRETTY_PRINT);
					exit();
				}
				else {
					$error = array("error" , "No matching category.");
					echo json_encode($error, JSON_PRETTY_PRINT);
					exit();
				}
			}
		}
	}
	else {
		$error = array("error" , "No datas.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
?>