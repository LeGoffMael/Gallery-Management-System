<?php
require_once('../Settings.php');
require_once('GalleryManager.php');

/**
 * TagGallery short summary.
 *
 * TagGallery description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class TagGallery extends GalleryManager
{
	private $_name;

	public function __construct($name,$page) {
		$this->_name = $name;
		$this->setPage($page);
		$this->setGallery();
    }

	public function setGallery() {
		$listImages = array();

		$tagImages = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT *
		FROM images i
		JOIN tags_images ti ON ti.idImage=i.idImage
		JOIN tags t ON t.idTag=ti.idTag
		WHERE t.nameTag = :name
		ORDER BY i.idImage DESC
		LIMIT ".$this->getOffset().", ". Settings::getInstance()->getLimit());

		$tagImages->bindValue(':name', $this->_name);
		$tagImages->execute();

		if($tagImages->rowCount() == 0) {
			echo "<h2 class='text-center'>No items to display</h2>";
		}
		else{
			while ($dataImage = $tagImages->fetch())
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
			$tagImages->closeCursor();
			$this->gallery = new Gallery($listImages,null, null, $this->getPage());
		}
	}
}

$name = filter_input(INPUT_POST, 'nameTag');
$page = filter_input(INPUT_POST, 'page');
$tagGallery = new TagGallery($name,$page);
if (!is_null($tagGallery->getGallery()))
	echo $tagGallery->getGallery()->toString();