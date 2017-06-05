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
    private $_name;
    private $_categoryParent;

	public function __construct($listImages,$name,$parent) {
		$this->_listImages = $listImages;
		$this->_name = $name;
		$this->_categoryParent = $parent;
    }

    /**
     * Ajoute une chaine comprenant la gallery complete au noeud racine
     */
    public function toString() {
		$res = "";
		if ($this->_name != null) {
			if ($this->_categoryParent == null)
				$res = "<h1>".$this->_name."::<a href='#categories?categoryName=null' onClick='ControllerGallery.setCategoriesChild(&#34;null&#34;);'>retour</a></h1>";
			else
				$res = "<h1>".$this->_name."::<a href='#categories?categoryName=".$this->_categoryParent."' onClick='ControllerGallery.setCategoriesChild(&#34;".$this->_categoryParent."&#34;);'>retour</a></h1>";
		}

		$res .= "<div class='row gallery scroll'><div class='col-md-12'><div id='demo-test-gallery' class='demo-gallery'><div class='gallery-container'>";
        for ($i = 0; $i < count($this->_listImages); $i++) {
            $res .= $this->_listImages[$i]->toString();
        }
        $res .= "</div></div></div><a href='www.legoffmael.fr'>next page</a></div>";
		return $res;
    }
}