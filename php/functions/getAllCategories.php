<?php
	header('Content-Type: application/json');
	require_once('../Settings.php');
	if (isset($_POST['idParent'])) {
		//If it's root return categories with no parents
		if ($_POST['idParent'] == -1) {
			$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT nameCategory, c1.idCategory, COUNT(ci.idCategory) AS nbElements
			FROM categories c1
			LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
			WHERE c1.idCategory NOT IN
				(SELECT idChild FROM parent_child)
			GROUP BY c1.idCategory
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
					$row_array['nb'] = $data['nbElements'];
					array_push($tabCategories,$row_array);
				}
				$categories->closeCursor();

				echo json_encode($tabCategories, JSON_PRETTY_PRINT);
				exit();
			}
		}
		//Return all childs of the parent
		else {
			$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.idCategory,nameCategory, COUNT(ci.idCategory) AS nbElements
			FROM categories c1
			LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
			WHERE c1.idCategory IN
			(SELECT idChild FROM categories c2
			JOIN parent_child pc ON pc.idParent=c2.idCategory
			WHERE c2.idCategory = :idParent)
			GROUP BY c1.idCategory
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
					$row_array['nb'] = $data['nbElements'];
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
		$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.idCategory,nameCategory, COUNT(ci.idCategory) AS nbElements
		FROM categories c1
		LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
		GROUP BY c1.idCategory
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
				$row_array['nb'] = $data['nbElements'];
				array_push($tabCategories,$row_array);
			}
			$categories->closeCursor();

			echo json_encode($tabCategories, JSON_PRETTY_PRINT);
			exit();
		}
	}
?>