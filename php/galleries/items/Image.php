<?php
require_once('Category.php');
require_once('Tag.php');
require_once('../FastImage.php');

/**
 * Image short summary.
 *
 * Image description.
 *
 * @version 1.0
 * @author Ma�l Le Goff
 */
class Image
{
	private $_url;
    private $_description;
    private $_categories;
    private $_tags;
    private $_score;
    private $_height;
    private $_width;

	public function __construct($url,$description,$categories,$tags,$score) {
		$this->_url = $url;
		$this->_description = $description;
		if($description == "") {
			$this->_description = "no description";
		}
		$this->_categories = $categories;
		$this->_tags = $tags;
		$this->_score = $score;
		$this->setSize();
    }

	/**
     * G�n�re les variables de dimension de l'image
     */
    private function setSize() {
		$image = new FastImage($this->_url);
		list($width, $height) = $image->getSize();
		$this->_width = $width;
		$this->_height = $height;
    }
	/**
     * Retourne une chaine contenant tous les noms de categeries auxquels appartient l'image
     */
    public function categoriesToString() {
        $res = "";
        for ($i = 0; $i < count($this->_categories); $i++) {
            if ($res != "") {
                $res .= " ; ";
            }
            $res .= $this->_categories[$i]->linkString();
        }
        return $res;
    }
	/**
     * Retourne une chaine contenant tous les noms de tags li�s l'image
     */
    public function tagsToString() {
        $res = "";
        for ($i = 0; $i < count($this->_tags); $i++) {
            if ($res != "") {
                $res .= " ; ";
            }
            $res .= $this->_tags[$i]->toString();
        }
        return $res;
    }
    /**
     * Retourne une chaine contenant les dimension de l'image au format largeur x hauteur
     */
    public function sizeToString() {
        return $this->_width."x".$this->_height;
    }
	/**
     * Retourne la chaine � afficher dans la gallery
     */
    public function toString() {
        $res = "";
        $res .= "<a class='col-md-4' href='".$this->_url."' data-size='".$this->sizeToString()."' data-categories='".$this->categoriesToString()."' data-tags='".$this->tagsToString()."'><img src='".$this->_url."' class='img-fluid' alt=''/><figure>".$this->_description."</figure></a>";
        return $res;
    }
}