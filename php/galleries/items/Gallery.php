<?php

/**
 * Gallery short summary.
 *
 * Gallery description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class Gallery
{
    private $_listImages;

	public function __construct($listImages) {
		$this->_listImages = $listImages;
    }

    /**
     * Ajoute une chaine comprenant la gallery complete au noeud racine
     */
    public function toString() {
        $res = "";
        $res .= "<div class='row gallery'><div class='col-md-12'><div id='demo-test-gallery' class='demo-gallery'><div class='gallery-container'>";
        for ($i = 0; $i < count($this->_listImages); $i++) {
            $res .= $this->_listImages[$i]->toString();
        }
        $res .= "</div></div></div></div>";
		return $res;
    }
}