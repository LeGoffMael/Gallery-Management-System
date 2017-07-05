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
class CategoryGallery extends GalleryManager {
	private $_nameCategory;
	private $_parent;

	public function __construct($nameCategory, $page) {
		$this->setPage($page);
		$this->_nameCategory = $nameCategory;
		$this->_parent =  $this->getCategoryParent($this->_nameCategory);
		$this->setGallery();
    }

    public function getCategoryParent($child) {
		$res = null;

		$categoriesParent = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT nameCategory
		FROM categories c1
		WHERE c1.idCategory IN
			(SELECT idParent FROM categories c2
			JOIN parent_child pc ON pc.idChild=c2.idCategory
			WHERE c2.nameCategory = :child)
		ORDER BY c1.nameCategory ASC");
		$categoriesParent->bindValue(':child', $child);
		$categoriesParent->execute();

		//Si il n'a pas d'enfant on affiche les images
		if($categoriesParent->rowCount() == 0)
		{
			$res = null;
		}
		//Sinon les enfants
		else{
			$tab = array();
			while ($dataCP = $categoriesParent->fetch())
			{
				array_push($tab,$dataCP['nameCategory']);
			}
			$categoriesParent->closeCursor();

			$res = $tab[0];
		}
		return $res;
	}

	/**
	 * Return category images
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
			echo "<h2>No images to display</h2>";
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

$name = filter_input(INPUT_POST, 'name');
$page = filter_input(INPUT_POST, 'page');
$categoryGallery = new CategoryGallery($name,$page);
//If category content image
if($categoryGallery->getGallery() != null)
    echo $categoryGallery->getGallery()->toString();