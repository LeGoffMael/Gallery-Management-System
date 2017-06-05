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
	private $_parent;

	public function __construct($nameCategory, $parent, $page) {
		$this->setPage($page);
		$this->_nameCategory = $nameCategory;
		$this->_parent = $parent;
		$this->setGallery();
    }

	/**
	 * Retourne les images de la catégorie
	 */
	public function setGallery() {
		$listImages = array();

		$categoryImages = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT *
		FROM images i
		JOIN categories_images ci ON ci.idImage=i.idImage
		JOIN categories c ON c.idCategory=ci.idCategory
		WHERE c.nameCategory = :name
		ORDER BY i.idImage DESC
		LIMIT ".$this->getOffset().", ". Settings::getInstance()->getLimit());

		$categoryImages->bindValue(':name', $this->_nameCategory);
		$categoryImages->execute();

		if($categoryImages->rowCount() == 0)
		{
			echo "<h2 class='text-center'>No items to display</h2>";
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

				//Gestion des votes
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
			$categoryImages->closeCursor();
			$this->gallery = new Gallery($listImages,$this->_nameCategory, $this->_parent, $this->getPage());
		}

	}
}