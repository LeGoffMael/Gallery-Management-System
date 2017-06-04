<?php
	header('Content-Type: application/json');
	require_once('../Settings.php');
	if (isset($_POST['idParent'])) {
		//If it's root return categories with no parents
		if ($_POST['idParent'] == -1) {
			$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT nameCategory, idCategory
			FROM categories c1
			WHERE c1.idCategory NOT IN
				(SELECT idChild FROM parent_child)
			ORDER BY c1.nameCategory ASC");
			$categories->execute();

			if($categories->rowCount() == 0)
			{
				exit();
			}
			else{
				$tabCategories = array();
				while ($data = $categories->fetch())
				{
					$row_array['id'] = $data['idCategory'];
					$row_array['text'] = $data['nameCategory'];
					array_push($tabCategories,$row_array);
				}
				$categories->closeCursor();

				echo json_encode($tabCategories, JSON_PRETTY_PRINT);
				exit();
			}
		}
		//Return all childs of the parent
		else {
			$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory,nameCategory
		FROM categories c1
		WHERE c1.idCategory IN
			(SELECT idChild FROM categories c2
			JOIN parent_child pc ON pc.idParent=c2.idCategory
			WHERE c2.idCategory = :idParent)
		ORDER BY c1.nameCategory ASC");
			$categories->bindValue(':idParent', $_POST['idParent']);
			$categories->execute();

			if($categories->rowCount() == 0)
			{
				exit();
			}
			else{
				$tabCategories = array();
				while ($data = $categories->fetch())
				{
					$row_array['id'] = $data['idCategory'];
					$row_array['text'] = $data['nameCategory'];
					array_push($tabCategories,$row_array);
				}
				$categories->closeCursor();

				echo json_encode($tabCategories, JSON_PRETTY_PRINT);
				exit();
			}
		}
	}
	//Return all categories
	else {
		$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory,nameCategory
		FROM categories
		ORDER BY nameCategory ASC");
		$categories->execute();

		if($categories->rowCount() == 0)
		{
			$error = array("error" , $categories->errorInfo());
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
		else{
			$tabCategories = array();
			while ($data = $categories->fetch())
			{
				$row_array['id'] = $data['idCategory'];
				$row_array['text'] = $data['nameCategory'];
				array_push($tabCategories,$row_array);
			}
			$categories->closeCursor();

			echo json_encode($tabCategories, JSON_PRETTY_PRINT);
			exit();
		}
	}
?>