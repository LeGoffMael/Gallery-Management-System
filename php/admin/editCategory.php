<?php
	//Edit a category by it name
	header('Content-Type: application/json');
	require_once('../Settings.php');

	if (isset($_POST['lastNameCategory']) and isset($_POST['newNameCategory']) and isset($_POST['urlImageCategory']) and isset($_POST['idParent'])) {
		$url = $_POST['urlImageCategory'];
		if ($url == "")
			$url = NULL;

		//Check last name
		$category = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idCategory
			FROM categories
			WHERE nameCategory = :name");
		$category->bindValue(':name', $_POST['lastNameCategory']);
		$category->execute();

		//If the last category doesn't exists
		if($category->rowCount() == 0) {
			$error = array("error" , "The selected category doesn't exists.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
		else {
			if ($result = $category->fetch(PDO::FETCH_ASSOC)) {
				$category->closeCursor();
			}
			$idCategory = $result['idCategory'];

			//Check parent
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
			//If the parent exist
			else {
				//Check if category is different to the parent
				if($idCategory != $_POST['idParent']) {
					if ($_POST['newNameCategory'] != "") {
						//Update the category
						$updateCategory = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE categories
						SET nameCategory = :name, urlImageCategory = :url
						WHERE idCategory = :id");

						$updateCategory->bindValue(':name', $_POST['newNameCategory']);
						$updateCategory->bindValue(':url', $url, PDO::PARAM_NULL);
						$updateCategory->bindValue(':id', $idCategory);

						//If update working
						if ($updateCategory->execute()) {
							//Delete all link with parents
							$delteteParents = Settings::getInstance()->getDatabase()->getDb()->prepare("DELETE FROM parent_child
								WHERE idChild = :idCurrent");
							$delteteParents->bindValue(':idCurrent', $idCategory);
							$delteteParents->execute();

							//If isn't root
							if($_POST['idParent'] != -1) {
								$addParent = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO parent_child SET
									idParent = :idParent,
									idChild = :idChild");
								$addParent->bindValue(':idParent', $_POST['idParent']);
								$addParent->bindValue(':idChild', $idCategory);
								$addParent->execute();
							}

							//Return success
							$success = array("success");
							echo json_encode($success, JSON_PRETTY_PRINT);
							exit();
						}
						//Return the query error
						else {
							$error = array("error" , $updateCategory->errorInfo());
							echo json_encode($error, JSON_PRETTY_PRINT);
							exit();
						}
					}
					//If name is empty
					else {
						$error = array("error" , "The new category name cannot be empty.");
						echo json_encode($error, JSON_PRETTY_PRINT);
						exit();
					}
				}
				//If the parent and the category have the same id
				else {
					$error = array("error" , "The category can not be its own parent !");
					echo json_encode($error, JSON_PRETTY_PRINT);
					exit();
				}
			}
		}
	}
	else {
		$error = array("error" , "No datas.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
?>