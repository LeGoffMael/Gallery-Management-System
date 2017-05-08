<?php
require_once('../Settings.php');
require_once('CategoriesManager.php');

/**
 * CategoriesGallery short summary.
 *
 * CategoriesGallery description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class ParentCategories extends CategoriesManager
{
	public function __construct() {
		$this->setCategories();
    }

	public function setCategories() {
		$list = array();
		$categoriesParent = Settings::getInstance()->getDatabase()->select(array('*'), array('categories'), array('idCategory NOT IN (SELECT idChild FROM parent_child)'), null, 'nameCategory ASC', null);
		if($categoriesParent->rowCount() == 0)
		{
			echo "<h2>No items to display</h2>";
		}
		else{
			while ($dataCP = $categoriesParent->fetch())
			{
				$idCategory = $dataCP['idCategory'];
				$nameCategory = $dataCP['nameCategory'];

				$urlImage = "";
				//On récupère l'id de l'image catégorie
				$idImg = Settings::getInstance()->getDatabase()->select(array('mainimages_categories.idMainImage'), array('mainimages_categories','categories'), array('mainimages_categories.idCategory = '.$idCategory,'categories.idCategory = mainimages_categories.idCategory'), null, null, null);
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
					$addresse = Settings::getInstance()->getDatabase()->select(array('*'),array('images'),array('idImage = '.$idImage),null,null,null);
					while ($dataU = $addresse->fetch())
					{
						$urlImage = $dataU['urlImage']; //l'adresse de l'urlImage
					}
					$addresse->closeCursor();
				}

				//On compte le nombre d'images dans la catégorie
				$nbElements = null;
				$tabIdImgs = array();
				$nbImg = Settings::getInstance()->getDatabase()->select(array('categories_images.idImage'), array('categories_images','categories'), array('categories_images.idCategory = '.$idCategory,'categories.idCategory = categories_images.idCategory'), null, null, null);
				while ($dataImages = $nbImg->fetch())
				{
					array_push($tabIdImgs, $dataImages['idImage']);
				}
				$nbImg->closeCursor();
				$nbElements = count($tabIdImgs);

				$categ = new Category($nameCategory, $urlImage, null, null, $nbElements);
				array_push($list, $categ);
			}
			$categoriesParent->closeCursor();
			$this->categories = new Categories($list);
		}
	}
}

$parentCategories = new ParentCategories();
echo $parentCategories->getCategories()->toString();