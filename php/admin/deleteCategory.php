<?php
	//Delete an category by this name
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['nameCategory'])) {
		$category = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory
			FROM categories
			WHERE nameCategory = :name");
		$category->bindValue(':name', $_POST['nameCategory']);
		$category->execute();

		//If no category find
		if($category->rowCount() == 0) {
			$error = array("error" , "The category name doesn't exist.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
		else {
			if ($result = $category->fetch(PDO::FETCH_ASSOC)) {
				$category->closeCursor();
			}
			$idCategory = $result['idCategory'];

			//Delete all references
			$deleteCategory = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM categories
				WHERE idCategory = :idCategory");
			$deleteCategory->bindValue(':idCategory', $idCategory);
			$deleteCategory->execute();
			$deleteImagesLink = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM categories_images
				WHERE idCategory = :idCategory");
			$deleteImagesLink->bindValue(':idCategory', $idCategory);
			$deleteImagesLink->execute();
			$deleteParentChild = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM tags_images
				WHERE idParent = :idParent OR idChild = :idChild");
			$deleteParentChild->bindValue(':idParent', $idCategory);
			$deleteParentChild->bindValue(':idChild', $idCategory);
			$deleteParentChild->execute();

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