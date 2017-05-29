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

		$top_images = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT *
		FROM images
		WHERE scoreImage > 0
		ORDER BY scoreImage
		DESC LIMIT ". Settings::getInstance()->getLimit());
		$top_images->execute();

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

				//Gestion des votes
				$up = null;
				$down = null;
				$vote = $this->getVote($idImage);
				if($vote == 0) {
					$up = false;
					$down = false;
				}
				else if($vote == 1) {
					$up = false;
					$down = true;
				}
				else if($vote == 2) {
					$up = true;
					$down = false;
				}

				$img = new Image($urlImage,$descritionImage,$categories,$tags,$scoreImage,$up,$down);
				array_push($listImagesTop, $img);
			}
			$top_images->closeCursor();
			$this->gallerie = new Gallery($listImagesTop,"Top",null);
		}
	}
}

$topGallery = new TopGallery();
echo $topGallery->getGallery()->toString();