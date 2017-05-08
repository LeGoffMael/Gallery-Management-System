<?php
require_once('../Settings.php');
require_once('GalleryManager.php');

/**
 * CategoryGallery short summary.
 *
 * CategoryGallery description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class CategoryGallery extends GalleryManager
{
	private $_nameCategory;

	public function __construct($nameCategory) {
		$this->_nameCategory = $nameCategory;
		$this->setGallery();
    }

	/**
	 * Retourne les images de la catégorie
	 */
	public function setGallery() {
		$listImages = array();
		$categoryImages = Settings::getInstance()->getDatabase()->select(array('*'), array('categories_images','categories','images'), array('categories.nameCategory = "'.$this->_nameCategory.'"','images.idImage = categories_images.idImage','categories.idCategory = categories_images.idCategory'), null, 'images.idImage DESC', Settings::getInstance()->getLimit());
		if($categoryImages->rowCount() == 0)
		{
			echo "<h2>No items to display</h2>";
		}
		else{
			while ($dataImage = $categoryImages->fetch())
			{
				$idImage = $dataImage['idImage'];
				$urlImage = $dataImage['urlImage'];
				$scoreImage = $dataImage['scoreImage'];
				$descritionImage = $dataImage['descriptionImage'];

				$categories = $this->getCategoriesImage($idImage);
				$tags = $this->getTagsImage($idImage);

				$img = new Image($urlImage,$descritionImage,$categories,$tags,$scoreImage);
				array_push($listImages, $img);
			}
			$categoryImages->closeCursor();
			$this->gallerie = new Gallery($listImages);
		}

	}
}
/*
$nameCategory = filter_input(INPUT_GET, 'nameCategory');

$categoryGallery = new CategoryGallery($nameCategory);
echo $categoryGallery->getGallery()->toString();*/