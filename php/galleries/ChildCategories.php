<?php
require_once('../Settings.php');
require_once('CategoriesManager.php');
require_once('CategoryGallery.php');

/**
 * ChildCategories short summary.
 *
 * ChildCategories description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class ChildCategories extends CategoriesManager
{
	private $_nameParent;

	public function __construct($name) {
		$this->_nameParent = $name;
		$this->_nameParent = $name;
		$this->setCategories();
    }

	/**
	 * Affiche les catégories enfants ou les images de la catégorie
	 */
	public function setCategories() {
		$list = array();
		
		$categoriesChild = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT * FROM categories WHERE idCategory IN (SELECT idChild FROM categories,parent_child WHERE nameCategory = :parent AND parent_child.idParent = categories.idCategory) ORDER BY nameCategory ASC");
		$categoriesChild->bindValue(':parent', $this->_nameParent);
		$categoriesChild->execute();

		//Si il n'a pas d'enfant on affiche les images
		if($categoriesChild->rowCount() == 0)
		{
			$categoryGallery = new CategoryGallery($this->_nameParent, $this->getCategoryParent($this->_nameParent));
			echo $categoryGallery->getGallery()->toString();
		}
		//Sinon les enfants
		else{
			while ($dataCC = $categoriesChild->fetch())
			{
				$idCategory = $dataCC['idCategory'];
				$nameCategory = $dataCC['nameCategory'];

				$urlImage = "";
				//On récupère l'id de l'image catégorie
				$idImg = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT mainimages_categories.idMainImage FROM mainimages_categories,categories WHERE mainimages_categories.idCategory = :idCategory AND categories.idCategory = mainimages_categories.idCategory");
				$idImg->bindValue(':idCategory', $idCategory);
				$idImg->execute();

				if($idImg->rowCount() == 0)
				{
					$urlImage = "images/defaultCategory.png";
				}
				else {
					$tabIdImgs = array();
					while ($dataImages = $idImg->fetch())
					{
						array_push($tabIdImgs,$dataImages['idMainImage']);
					}
					$idImg->closeCursor();

					$nbIdImgs = count($tabIdImgs);
					$alea = rand(0, $nbIdImgs-1);
					$idImage = $tabIdImgs[$alea];

					//On récupère l'url de l'image catégorie
					$urlImage = null;

					$addresse = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT * FROM images WHERE idImage = :idImage");
					$addresse->bindValue(':idImage', $idImage);
					$addresse->execute();

					while ($dataU = $addresse->fetch())
					{
						$urlImage = $dataU['urlImage']; //l'adresse de l'urlImage
					}
					$addresse->closeCursor();
				}

				//On compte le nombre d'images dans la catégorie
				$nbElements = null;
				$tabIdImgs = array();

				$nbImg = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT categories_images.idImage FROM categories_images,categories WHERE categories_images.idCategory = :idCategory AND categories.idCategory = categories_images.idCategory");
				$nbImg->bindValue(':idCategory', $idCategory);
				$nbImg->execute();

				while ($dataImages = $nbImg->fetch())
				{
					array_push($tabIdImgs, $dataImages['idImage']);
				}
				$nbImg->closeCursor();
				$nbElements = count($tabIdImgs);

				$categ = new Category($nameCategory, $urlImage, null, null, $nbElements);
				array_push($list, $categ);
			}
		}
		$categoriesChild->closeCursor();
		$this->categories = new Categories($list,$this->_nameParent, $this->getCategoryParent($this->_nameParent));
	}
}

$nameParent = filter_input(INPUT_GET, 'nameParent');

$childCategories = new ChildCategories($nameParent);
echo $childCategories->getCategories()->toString();