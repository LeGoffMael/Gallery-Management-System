<?php
	//Edit new tags
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['tags'])) {
		$tabTags = json_decode($_POST["tags"]);
		$newTags= array();

		//Check tags which doesn't exist
		if(!empty($tabTags)) {
			foreach($tabTags as $name){
				$tags = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idTag
					FROM tags
					WHERE nameTag = :name");
				$tags->bindValue(':name', $name);
				$tags->execute();

				//If doesn't exist
				if($tags->rowCount() == 0) {
					if ($result = $tags->fetch(PDO::FETCH_ASSOC)) {
						$tags->closeCursor();
					}
					//Add new tag in the array
					array_push($newTags, $name);
				}
			}
		}

		//If thay are new tags
		if(!empty($newTags)) {
			//Insert all new
			foreach ($newTags as $name){
				$addTag = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO tags SET
					nameTag = :name");

				$addTag->bindValue(':name', $name);
				$addTag->execute();
			}
			//Return success
			$success = array("success");
			echo json_encode($success, JSON_PRETTY_PRINT);
			exit();
		}
		else {
			$error = array("error" , "All these tags already exist.");
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