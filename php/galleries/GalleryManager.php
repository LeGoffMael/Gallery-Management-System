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
		$categories = Settings::getInstance()->getDatabase()->select(array('categories.*'), array('categories_images','categories','images'), array('images.idImage = '.$idImage, 'images.idImage = categories_images.idImage', 'categories.idCategory = categories_images.idCategory'), null, null, null);
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
		$tags = Settings::getInstance()->getDatabase()->select(array('tags.*'), array('tags_images','tags','images'), array('images.idImage = '.$idImage, 'images.idImage = tags_images.idImage', 'tags.idTag = tags_images.idTag'), null, null, null);
		while ($dataTag = $tags->fetch())
		{
			$idTag = $dataTag['idTag'];
			$name = $dataTag['nameTag'];

			$tag = new Tag($name);
			array_push($listTags, $tag);
		}
		$tags->closeCursor();
		return $listTags;
	}

	/**
	 * Retourne la gallery
	 * @return mixed
	 */
	public function getGallery() {
		return $this->gallerie;
	}
}