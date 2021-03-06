<?php

/**
 * Gallery short summary.
 *
 * Gallery description.
 *
 * @version 1.0
 * @author Ma�l Le Goff
 */
class Gallery
{
    private $_listImages;
    private $_name;
    private $_categoryParent;
	private $_page;

	public function __construct($listImages,$name,$parent,$page) {
		$this->_listImages = $listImages;
		$this->_name = $name;
		$this->_categoryParent = $parent;
		$this->_page = $page;
    }

    /**
     * Ajoute une chaine comprenant la gallery complete au noeud racine
     */
    public function toString() {
		$nextPage = $this->_page + 1;
		$res = "";
		

		//$res .= "<div class='row gallery'><div class='col-md-12'><div class='gallery-container'>";
        for ($i = 0; $i < count($this->_listImages); $i++) {
            $res .= $this->_listImages[$i]->toString();
        }
        $res .= "</div></div><div class='pageGallery' data-nextPage='".$nextPage."'></div></div>";
		return $res;
    }
}