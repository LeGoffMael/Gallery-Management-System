<?php
	//Delete all tags, categories and images which aren't referenced to other element
	header('Content-Type: application/json');
	require_once('../Settings.php');

	$imagesUnreferenced = false;
	$categoriesUnreferenced = false;
	$tagsUnreferenced = false;

	//Images that are not in a category
	$images = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE i FROM images i
		LEFT JOIN categories_images ci ON ci.idImage = i.idImage
		WHERE ci.idImage IS NULL");
	//If delete not working
	if (!$images->execute()) {
		$error = array("error" , $images->errorInfo());
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
	//If they has images unreferenced
	if($images->rowCount() != 0) {
		$imagesUnreferenced = true;
	}

	//Categories without children and without images
	$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE c FROM categories c
		LEFT JOIN categories_images ci ON ci.idCategory = c.idCategory
		LEFT JOIN parent_child pc ON pc.idParent = c.idCategory
		WHERE ci.idCategory IS NULL AND pc.idParent IS NULL");
	//If delete not working
	if (!$categories->execute()) {
		$error = array("error" , $categories->errorInfo());
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
	//If they has categories unreferenced
	if($categories->rowCount() != 0) {
		$categoriesUnreferenced = true;
	}

	//Tags without images
	$tags = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE t FROM tags t
		LEFT JOIN tags_images ti ON ti.idTag = t.idTag
		WHERE ti.idTag IS NULL");
	//If delete not working
	if (!$tags->execute()) {
		$error = array("error" , $tags->errorInfo());
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
	//If they has tags unreferenced
	if($tags->rowCount() != 0) {
		$tagsUnreferenced = true;
	}

	//If records have been deleted
	if($categoriesUnreferenced and $categoriesUnreferenced and $tagsUnreferenced) {
		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
		exit();
	}
	else {
		$error = array("error" , "There are no unreferenced records.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
?>