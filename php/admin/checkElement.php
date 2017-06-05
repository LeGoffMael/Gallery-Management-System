<?php
	header('Content-Type: application/json');
	require_once('../Settings.php');
	//Check if the url is in the database
	if (isset($_POST['urlImage'])) {
		$image = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT urlImage, descriptionImage, ci.idCategory, ti.idTag
			FROM images i
			LEFT JOIN categories_images ci ON ci.idImage=i.idImage
			LEFT JOIN tags_images ti ON ti.idImage=i.idImage
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
			$url = "";
			$description = "";
			$categories = array();
			$tags = array();
			while ($data = $image->fetch())
			{
				$url = $data['urlImage'];
				$description = $data['descriptionImage'];
				//Add if not exist
				if (!in_array($data['idCategory'], $categories))
				{
					array_push($categories, $data['idCategory']);
				}
				if (!in_array($data['idTag'], $tags))
				{
					array_push($tags, $data['idTag']);
				}
			}
			$image->closeCursor();

			$success = array("success", $url, $description, $categories, $tags);
			echo json_encode($success, JSON_PRETTY_PRINT);
			exit();
		}
	}
	//Check if the category name is in the database
	else if (isset($_POST['nameCategory'])) {
		$category = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c.nameCategory,c.urlImageCategory,pc2.idParent
			FROM categories c
			LEFT JOIN parent_child pc2 ON pc2.idChild=c.idCategory
			WHERE nameCategory = :nameCategory");
		$category->bindValue(':nameCategory', $_POST['nameCategory']);
		$category->execute();

		//If no data find
		if($category->rowCount() == 0)
		{
			$error = array("error" , "The category name doesn't exist.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
		else{
			$name = "";
			$url = "";
			$parent = "";
			while ($data = $category->fetch())
			{
				$name = $data['nameCategory'];
				$url = $data['urlImageCategory'];
				$parent = $data['idParent'];
			}
			$category->closeCursor();

			$success = array("success", $name, $url, $parent);
			echo json_encode($success, JSON_PRETTY_PRINT);
			exit();
		}
	}
	//If no parameters
	else {
		$error = array("error" , "No datas.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
?>