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
 * @author Ma�l Le Goff
 */
class ChildCategories extends CategoriesManager
{
	private $_nameParent;

	public function __construct($name) {
		$this->_nameParent = $name;
		$this->setCategories();
    }

	/**
	 * Affiche les cat�gories enfants ou les images de la cat�gorie
	 */
	public function setCategories() {
		$list = array();
		$categoriesChild = Settings::getInstance()->getDatabase()->select(array('*'), array('categories'), array('idCategory IN (SELECT idChild FROM categories,parent_child WHERE nameCategory = "'.$this->_nameParent.'" AND parent_child.idParent = categories.idCategory)'), null, 'nameCategory ASC', null);
		//Si il n'a pas d'enfant on affiche les images
		if($categoriesChild->rowCount() == 0)
		{
			$categoryGallery = new CategoryGallery($this->_nameParent);
			echo $categoryGallery->getGallery()->toString();
		}
		//Sinon les enfants
		else{
			while ($dataCC = $categoriesChild->fetch())
			{
				$idCategory = $dataCC['idCategory'];
				$nameCategory = $dataCC['nameCategory'];

				$urlImage = "";
				//On r�cup�re l'id de l'image cat�gorie
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

					//On r�cup�re l'url de l'image cat�gorie
					$urlImage = null;
					$addresse = Settings::getInstance()->getDatabase()->select(array('*'),array('images'),array('idImage = '.$idImage),null,null,null);
					while ($dataU = $addresse->fetch())
					{
						$urlImage = $dataU['urlImage']; //l'adresse de l'urlImage
					}
					$addresse->closeCursor();
				}

				//On compte le nombre d'images dans la cat�gorie
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
		}
		$categoriesChild->closeCursor();
		$this->categories = new Categories($list);
	}
}

$nameParent = filter_input(INPUT_GET, 'nameParent');

$childCategories = new ChildCategories($nameParent);
echo $childCategories->getCategories()->toString();