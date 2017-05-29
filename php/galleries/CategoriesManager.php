<?php
require_once('../Settings.php');
require_once('items/Categories.php');
require_once('items/Category.php');

/**
 * CategoriesManager short summary.
 *
 * CategoriesManager description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
abstract class CategoriesManager
{
	protected $categories;

	public function __construct() {
    }

	/**
	 * Crée la gallery de categories
	 */
	abstract public function setCategories();

	public function getCategoryParent($child) {
		$res = null;

		$categoriesParent = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT nameCategory
		FROM categories c1
		WHERE c1.idCategory IN
			(SELECT idParent FROM categories c2
			JOIN parent_child pc ON pc.idChild=c2.idCategory
			WHERE c2.nameCategory = :child)
		ORDER BY c1.nameCategory ASC");
		$categoriesParent->bindValue(':child', $child);
		$categoriesParent->execute();

		//Si il n'a pas d'enfant on affiche les images
		if($categoriesParent->rowCount() == 0)
		{
			$res = null;
		}
		//Sinon les enfants
		else{
			$tab = array();
			while ($dataCP = $categoriesParent->fetch())
			{
				array_push($tab,$dataCP['nameCategory']);
			}
			$categoriesParent->closeCursor();

			$res = $tab[0];
		}
		return $res;
	}

	/**
	 * Retourne la gallery de categories
	 * @return mixed
	 */
	public function getCategories() {
		return $this->categories;
	}
}