<?php
require_once('../Settings.php');
require_once('GalleryManager.php');

/**
 * Top short summary.
 *
 * Top description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class TopGallery extends GalleryManager
{
	public function __construct() {
		$this->setGallery();
    }

	/**
	 * Retourne les dernieres images mises en ligne
	 */
	public function setGallery() {
		$listImagesTop = array();
		$top_images = Settings::getInstance()->getDatabase()->select(array('*'), array('images'), array('scoreImage > 0'), null, 'scoreImage DESC', Settings::getInstance()->getLimit());
		if($top_images->rowCount() == 0)
		{
			echo "<h2>No items to display</h2>";
		}
		else{
			while ($dataImage = $top_images->fetch())
			{
				$idImage = $dataImage['idImage'];
				$urlImage = $dataImage['urlImage'];
				$scoreImage = $dataImage['scoreImage'];
				$descritionImage = $dataImage['descriptionImage'];

				$categories = $this->getCategoriesImage($idImage);
				$tags = $this->getTagsImage($idImage);

				$img = new Image($urlImage,$descritionImage,$categories,$tags,$scoreImage);
				array_push($listImagesTop, $img);
			}
			$top_images->closeCursor();
			$this->gallerie = new Gallery($listImagesTop,"Top",null);
		}
	}
}

$topGallery = new TopGallery();
echo $topGallery->getGallery()->toString();