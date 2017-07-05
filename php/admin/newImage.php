<?php
	//Add a new image in the database
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['urlImage']) and isset($_POST['descriptionImage']) and isset($_POST['tabCategories']) and isset($_POST['tabTags'])) {
		$description = $_POST['descriptionImage'];
		if ($description == "")
			$description = NULL;

		$image = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT urlImage
			FROM images
			WHERE urlImage = :urlImage");
		$image->bindValue(':urlImage', $_POST['urlImage']);
		$image->execute();

		$tabCategories = json_decode($_POST["tabCategories"]);
		$tabTags = json_decode($_POST["tabTags"]);

		//If the image doesn't exist
		if($image->rowCount() == 0)
		{
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

			//Insert the image
			$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO images SET
				urlImage = :url,
				dateImage = NOW(),
				scoreImage = 0,
				descriptionImage = :desc");

			$requete->bindValue(':url', $_POST['urlImage']);
			$requete->bindValue(':desc', $description, PDO::PARAM_NULL);

			//If insert working
			if ($requete->execute()) {
				$idInsert = Settings::getInstance()->getDatabase()->getDb()->lastInsertId();

                //If there are corresponding categories
                if (!empty($categories_exist)) {
					//Link all categories with the image
					foreach ($categories_exist as $value){
						$requete2 = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO categories_images SET
							idCategory = :idCategory,
							idImage = :idImage");

						$requete2->bindValue(':idCategory', $value);
						$requete2->bindValue(':idImage', $idInsert);
						$requete2->execute();
					}
                }

				//Link all tags with the image
				if(!empty($tags_exist)) {
					foreach ($tags_exist as $value){
						$requete3 = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO tags_images SET
					idTag = :idTag,
					idImage = :idImage");

						$requete3->bindValue(':idTag', $value);
						$requete3->bindValue(':idImage', $idInsert);
						$requete3->execute();
					}
				}

				//Return success
				$success = array("success");
				echo json_encode($success, JSON_PRETTY_PRINT);
				exit();
			}
			//Return the query error
			else {
				$error = array("error" , $requete->errorInfo());
				echo json_encode($error, JSON_PRETTY_PRINT);
				exit();
			}
		}
		else{
			$error = array("error" , "The Url already exist.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
	}
	else {
		$error = array("error" , "No datas.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
?>