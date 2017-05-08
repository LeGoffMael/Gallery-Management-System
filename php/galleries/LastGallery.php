<?php
require_once('../Settings.php');
require_once('GalleryManager.php');

/**
 * Last short summary.
 *
 * Last description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class LastGallery extends GalleryManager
{
	public function __construct() {
		$this->setGallery();
    }

	/**
	 * Retourne les dernieres images mises en ligne
	 */
	public function setGallery() {
		$listImages = array();
		$last_images = Settings::getInstance()->getDatabase()->select(array('*'), array('images'), null, null, 'idImage DESC', Settings::getInstance()->getLimit());
		if($last_images->rowCount() == 0)
		{
			echo "<h2>No items to display</h2>";
		}
		else{
			while ($dataImage = $last_images->fetch())
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
			$last_images->closeCursor();
			$this->gallerie = new Gallery($listImages,"Latest",null);
		}
	}
}
$lastGallery = new LastGallery();
echo $lastGallery->getGallery()->toString();
