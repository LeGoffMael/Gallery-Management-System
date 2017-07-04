<?php
require_once('Category.php');

/**
 * Categories short summary.
 *
 * Categories description.
 *
 * @version 1.0
 * @author legof
 */
class Categories
{
    private $_listCategories;
	private $_name;
	private $_parent;

	public function __construct($list, $name, $parent) {
        $this->_listCategories = $list;
		$this->_name = $name;
		$this->_parent = $parent;
    }

	/**
     * Ajoute une chaine comprenant la gallerie de categories complete au noeud racine
     */
    public function toString() {
		if ($this->_name == null) {
			$res = "<h1>Categories</h1>";
		}
		else {
			if ($this->_parent == null) {
				$res = "<h1>".$this->_name."::<a class='categoryLink' href='#categories?categoryName=null' data-categoryLink='null'>return</a></h1>";
			}
			else
				$res = "<h1>".$this->_name."::<a class='categoryLink' href='#categories?categoryName=".$this->_parent."' data-categoryLink='".$this->_parent."'>return</a></h1>";
		}
		$res .= "<section class='row'><ul class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id='categorie-list'>";
        for ($i = 0; $i < count($this->_listCategories); $i++) {
            $res .= $this->_listCategories[$i]->toString();
        }
        $res .= "</ul></section>";
		return $res;
    }
}