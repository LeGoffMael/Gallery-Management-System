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

		$categoriesChild = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.nameCategory, i.urlImage, COUNT(ci.idCategory) AS nbElements
		FROM categories c1
		LEFT JOIN mainimages_categories mic ON mic.idCategory=c1.idCategory
		LEFT JOIN images i ON mic.idMainImage=i.idImage
		LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
		WHERE c1.idCategory IN
			(SELECT idChild FROM categories c2
			JOIN parent_child pc ON pc.idParent=c2.idCategory
			WHERE c2.nameCategory = :parent)
		GROUP BY c1.idCategory,i.urlImage
		ORDER BY c1.nameCategory ASC");
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
			while ($data = $categoriesChild->fetch())
			{
				$nameCategory = $data['nameCategory'];
				$nbElements = $data['nbElements'];

				$urlImage = "";
				if (is_null($data['urlImage'])) {
					$urlImage = "images/defaultCategory.png";
				}
				else {
					$urlImage = $data['urlImage'];
				}

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