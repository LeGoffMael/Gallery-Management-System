<?php
require_once('../Settings.php');
require_once('CategoriesManager.php');

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
	private $_page;

	public function __construct($name,$page) {
		$this->_nameParent = $name;
		$this->_page = $page;
		$this->setCategories();
    }

	/**
	 * Display children categories or images in category
	 */
	public function setCategories() {
		$list = array();

		$categoriesChild = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.nameCategory, c1.urlImageCategory, COUNT(ci.idCategory) AS nbElements
		FROM categories c1
		LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
		WHERE c1.idCategory IN
			(SELECT idChild FROM categories c2
			JOIN parent_child pc ON pc.idParent=c2.idCategory
			WHERE c2.nameCategory = :parent)
		GROUP BY c1.idCategory, c1.urlImageCategory
		ORDER BY c1.nameCategory ASC");
		$categoriesChild->bindValue(':parent', $this->_nameParent);
		$categoriesChild->execute();

		while ($data = $categoriesChild->fetch())
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
		$categoriesChild->closeCursor();
		//Display child categories
		$this->categories = new Categories($list,$this->_nameParent, $this->getCategoryParent($this->_nameParent));
		echo $this->getCategories()->toString();
	}
	
}

$nameParent = filter_input(INPUT_POST, 'nameParent');
$page = filter_input(INPUT_POST, 'page');
$childCategories = new ChildCategories($nameParent,$page);