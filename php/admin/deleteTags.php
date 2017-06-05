<?php
	//Edit tags by name
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['tags'])) {
		$tabTags = json_decode($_POST["tags"]);
		$existingTags = array();

		//Check tags which exist
		if(!empty($tabTags)) {
			foreach($tabTags as $id){
				$tags = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idTag
					FROM tags
					WHERE idTag = :id");
				$tags->bindValue(':id', $id);
				$tags->execute();

				//If exist
				if($tags->rowCount() != 0) {
					if ($result = $tags->fetch(PDO::FETCH_ASSOC)) {
						$tags->closeCursor();
					}
					//Add tag in the array
					array_push($existingTags, $id);
				}
			}
		}

		//If thay are new tags
		if(!empty($existingTags)) {
			//Delete all existing tags references
			foreach ($existingTags as $id){
				$deleteTags = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM tags
					WHERE idTag = :idTag");
				$deleteTags->bindValue(':idTag', $id);
				$deleteTags->execute();
				$deleteImagesLink = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM tags_images
					WHERE idTag = :idTag");
				$deleteImagesLink->bindValue(':idTag', $id);
				$deleteImagesLink->execute();
			}

			//Return success
			$success = array("success");
			echo json_encode($success, JSON_PRETTY_PRINT);
			exit();
		}
		else {
			$error = array("error" , "None of these tags exist.");
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