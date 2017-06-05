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
	public function __construct($page) {
		$this->setPage($page);
		$this->setGallery();
    }

	/**
	 * Retourne les dernieres images mises en ligne
	 */
	public function setGallery() {
		$listImages = array();

		$last_images = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT *
		FROM images
		ORDER BY idImage DESC
		LIMIT ".$this->getOffset().", ". Settings::getInstance()->getLimit());
		$last_images->execute();

		if($last_images->rowCount() == 0)
		{
			echo "<h2 class='text-center'>No items to display</h2>";
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

				//Vote management
				$up = null;
				$down = null;
				$vote = $this->getVote($idImage);
				if($vote == -1) {
					$up = false;
					$down = false;
				}
				else if($vote == 0) {
					$up = false;
					$down = true;
				}
				else if($vote == 1) {
					$up = true;
					$down = false;
				}

				$img = new Image($urlImage,$descritionImage,$categories,$tags,$scoreImage,$up,$down);
				array_push($listImages, $img);
			}
			$last_images->closeCursor();
			$this->gallery = new Gallery($listImages,null,null,$this->getPage());
		}
	}
}

$page = filter_input(INPUT_POST, 'page');
$lastGallery = new LastGallery($page);
if (!is_null($lastGallery->getGallery()))
	echo $lastGallery->getGallery()->toString();