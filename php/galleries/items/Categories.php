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

	public function __construct($list) {
        $this->_listCategories = $list;
    }

	/**
     * Ajoute une chaine comprenant la gallerie de categories complete au noeud racine
     */
    public function toString() {
        $res = "";
        $res .= "<section class='row'><ul class='col-lg-12 col-md-12 col-sm-12 col-xs-12' id='categorie-list'>";
        for ($i = 0; $i < count($this->_listCategories); $i++) {
            $res .= $this->_listCategories[$i]->toString();
        }
        $res .= "</ul></section>";
		return $res;
    }
}