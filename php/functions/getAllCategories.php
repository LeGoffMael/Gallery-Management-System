<?php
	header('Content-Type: application/json');
	require_once('../Settings.php');

	$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT nameCategory
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
			array_push($tabCategories,$data['nameCategory']);
		}
		$categories->closeCursor();

		echo json_encode($tabCategories, JSON_PRETTY_PRINT);
		exit();
	}
?>