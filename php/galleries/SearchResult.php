<?php
require_once('../Settings.php');
require_once('GalleryManager.php');

/**
 * SearchResult short summary.
 *
 * SearchResult description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class SearchResult extends GalleryManager
{
	private $_terms;

	public function __construct($terms,$page) {
		$this->_terms = explode(" ", $terms);
		$this->setPage($page);
		$this->setGallery();
    }

	/**
	 * Return the gallery result
	 */
	public function setGallery() {
		$listImages = array();

		//Generate all conditions
		$termsConditions = '';
		for ($i = 0; $i < count($this->_terms); $i++) {
			$term = ":term".$i;
			if ($i > 0)
				$termsConditions .= " AND ";
			$termsConditions .= "i.descriptionImage LIKE ".$term." OR c.nameCategory LIKE ".$term." OR t.nameTag LIKE ".$term;
		}
		$search = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT DISTINCT i.idImage, i.urlImage, i.scoreImage, i.descriptionImage
		FROM images i
		LEFT JOIN categories_images ci ON ci.idImage=i.idImage
		LEFT JOIN categories c ON c.idCategory=ci.idCategory
		LEFT JOIN tags_images ti ON ti.idImage=i.idImage
		LEFT JOIN tags t ON t.idTag=ti.idTag
		WHERE ".$termsConditions."
		GROUP BY i.idImage, c.nameCategory, t.nameTag
		ORDER BY i.idImage DESC
		LIMIT ".$this->getOffset().", ". Settings::getInstance()->getLimit());

		for ($i = 0; $i < count($this->_terms); $i++) {
			$term = ":term".$i;
			$search->bindValue($term, "%".$this->_terms[$i]."%" ,PDO::PARAM_STR);
		}
		$search->execute();

		if($search->rowCount() == 0) {
			echo "<h2>No items to display</h2>";
		}
		else{
			while ($dataImage = $search->fetch()) {
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
			$search->closeCursor();
			$this->gallery = new Gallery($listImages,null,null,$this->getPage());
		}
	}
}

$page = filter_input(INPUT_POST, 'page');
$terms = filter_input(INPUT_POST, 'terms');
$search = new SearchResult($terms,$page);
if (!is_null($search->getGallery()))
	echo $search->getGallery()->toString();