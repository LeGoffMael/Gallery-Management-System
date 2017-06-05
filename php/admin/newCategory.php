<?php
	//Add a new category in the database
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['nameCategory']) and isset($_POST['urlImageCategory']) and isset($_POST['idParent'])) {
		$url = $_POST['urlImageCategory'];
		if ($url == "")
			$url = NULL;

		$category = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory
			FROM categories
			WHERE nameCategory = :name");
		$category->bindValue(':name', $_POST['nameCategory']);
		$category->execute();

		//If the category doesn't exist
		if($category->rowCount() == 0) {
			$parent = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory
				FROM categories
				WHERE idCategory = :id");
			$parent->bindValue(':id', $_POST['idParent']);
			$parent->execute();

			//If the parent doesn't exist
			if($parent->rowCount() == 0 and $_POST['idParent'] != -1) {
				$error = array("error" , "The parent doesn't exist.");
				echo json_encode($error, JSON_PRETTY_PRINT);
				exit();
			}
			else {
				//Insert the category
				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO categories SET
					nameCategory = :name,
					urlImageCategory = :url");
				$requete->bindValue(':name', $_POST['nameCategory']);
				$requete->bindValue(':url', $url, PDO::PARAM_NULL);

				//If insert working
				if ($requete->execute()) {
					$idInsert = Settings::getInstance()->getDatabase()->getDb()->lastInsertId();

					//If isn't root
					if($_POST['idParent'] != -1) {
						$requete2 = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO parent_child SET
						idParent = :idParent,
						idChild = :idChild");
						$requete2->bindValue(':idParent', $_POST['idParent']);
						$requete2->bindValue(':idChild', $idInsert);
						$requete2->execute();
					}

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
		}
		//If the category already exists
		else {
			$error = array("error" , "The category name already exists.");
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