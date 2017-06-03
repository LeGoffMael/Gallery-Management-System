<?php
require_once('../Settings.php');
require_once('items/Gallery.php');
require_once('items/Image.php');
require_once('items/Categories.php');
require_once('items/Category.php');
require_once('items/Tag.php');

/**
 * GalleryManager short summary.
 *
 * GalleryManager description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
abstract class GalleryManager
{
	protected $gallerie;

	public function __construct() {
    }

	/**
	 * Crée la gallery
	 */
	abstract public function setGallery();

	/**
	 * Retourne un tableau des catégories liées à l'index de l'image passé en paramètre
	 * @param mixed $idImage
	 * @return array
	 */
	public function getCategoriesImage($idImage) {
		$listCategories = array();

		$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT categories.* FROM categories_images,categories,images WHERE images.idImage = :idImage AND images.idImage = categories_images.idImage AND categories.idCategory = categories_images.idCategory");
		$categories->bindValue(':idImage', $idImage);
		$categories->execute();

		while ($dataCategory = $categories->fetch())
		{
				$idCategory = $dataCategory['idCategory'];
				$title = $dataCategory['nameCategory'];

				//L'image principal de la catégory
				$categoryImage = null;

				//On établit la hiérarchie entre catégorie
				$categoryParent = null;
				$categoriesChild = null;

				$nbElements = null;

				$categ = new Category($title,$categoryImage,$categoryParent,$categoriesChild,$nbElements);
				array_push($listCategories, $categ);
		}
		$categories->closeCursor();
		return $listCategories;
	}
	/**
	 * Retourne un tableau des tags liées à l'index de l'image passé en paramètre
	 * @param mixed $idImage
	 * @return array
	 */
	public function getTagsImage($idImage) {
		$listTags = array();

		$tags = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT nameTag FROM images i
		LEFT JOIN tags_images ti ON ti.idImage=i.idImage
		LEFT JOIN tags t ON t.idTag=ti.idTag
		WHERE i.idImage = :idImage");
		$tags->bindValue(':idImage', $idImage);
		$tags->execute();

		while ($dataTag = $tags->fetch())
		{
			$name = $dataTag['nameTag'];

			$tag = new Tag($name);
			array_push($listTags, $tag);
		}
		$tags->closeCursor();
		return $listTags;
	}
	/**
	 * Retourne un tableau contenant : si pas de vote (0), si vote négatif (1), si vote positif (2)
	 * @param mixed $idImage
	 */
	public function getVote($idImage) {
		$res = null;
		$ip = $_SERVER['REMOTE_ADDR'];

		$ip_score = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT valueScore FROM ip_score WHERE ip = :ip AND idImage = :idImage");
		$ip_score->bindValue(':ip', $ip);
		$ip_score->bindValue(':idImage', $idImage);
		$ip_score->execute();

		if ($ip_score->rowCount() == 0) //si l'IP n'a jamais voté
		{
			$res = -1;
		}
		else //si l'IP à déjà voté
		{
			$last_score = null;
			while ($dataIPS = $ip_score->fetch())
			{
				$last_score = $dataIPS['valueScore'];
			}
			$ip_score->closeCursor();

			$res = $last_score;
		}

		return $res;
	}

	/**
	 * Retourne la gallery
	 * @return mixed
	 */
	public function getGallery() {
		return $this->gallerie;
	}
}