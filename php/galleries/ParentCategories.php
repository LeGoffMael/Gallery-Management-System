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

		$categoriesParent = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.nameCategory, c1.urlImageCategory, COUNT(ci.idCategory) AS nbElements
		FROM categories c1
		LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
		WHERE c1.idCategory NOT IN (SELECT idChild FROM parent_child)
		GROUP BY c1.idCategory,c1.urlImageCategory
		ORDER BY c1.nameCategory ASC");
		$categoriesParent->execute();

		if($categoriesParent->rowCount() == 0)
		{
			echo "<h2>No items to display</h2>";
		}
		else{
			while ($data = $categoriesParent->fetch())
			{
				$nameCategory = $data['nameCategory'];
				$nbElements = $data['nbElements'];

				$urlImage = "";
				if (is_null($data['urlImageCategory'])) {
					$urlImage = "images/defaultCategory.png";
				}
				else {
					$urlImage = $data['urlImageCategory'];
				}

				$categ = new Category($nameCategory, $urlImage, null, null, $nbElements);
				array_push($list, $categ);
			}
			$categoriesParent->closeCursor();
			$this->categories = new Categories($list,null,null);
		}
	}
}

$parentCategories = new ParentCategories();
echo $parentCategories->getCategories()->toString();