<?php
require_once('../Settings.php');
require_once('GalleryManager.php');

/**
 * GalleryWithoutCategory short summary.
 *
 * GalleryWithoutCategory description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class GalleryWithoutCategory extends GalleryManager {

    public function __construct($page) {
		$this->setPage($page);
		$this->setGallery();
    }

    /**
     * Return category images
     */
	public function setGallery() {
		$listImages = array();

		$imagesWithoutCategory = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT *
		FROM images i
        LEFT JOIN categories_images ci ON ci.idImage=i.idImage
        WHERE ci.idImage IS NULL
		ORDER BY i.idImage DESC
		LIMIT ".$this->getOffset().", ". Settings::getInstance()->getLimit());
		$imagesWithoutCategory->execute();

		if($imagesWithoutCategory->rowCount() == 0)
		{
			echo "<h2>No images to display</h2>";
		}
		else{
			while ($dataImage = $imagesWithoutCategory->fetch())
			{
				$idImage = $dataImage['idImage'];
				$urlImage = $dataImage['urlImage'];
				$scoreImage = $dataImage['scoreImage'];
				$descritionImage = $dataImage['descriptionImage'];

				$categories = $this->getCategoriesImage($idImage);
				$tags = $this->getTagsImage($idImage);

				//Vote managment
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
			$imagesWithoutCategory->closeCursor();
			$this->gallery = new Gallery($listImages,null, null, $this->getPage());
		}

	}
}

$page = filter_input(INPUT_POST, 'page');
$galleryWithoutCategory = new GalleryWithoutCategory($page);
//If category content image
if($galleryWithoutCategory->getGallery() != null)
    echo $galleryWithoutCategory->getGallery()->toString();