<?php

/**
 * Category short summary.
 *
 * Category description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class Category
{
	private $_name;
    private $_categoryImage;
    private $_categoryParent;
    private $_categoriesChild;
    private $_nbElements;

	public function __construct($name,$image,$parent,$childs,$nb) {
		$this->_name = $name;
        $this->_categoryImage = $image;
        $this->_categoryParent = $parent;
        $this->_categoriesChild = $childs;
        $this->_nbElements = $nb;
    }

	/**
     * Retourne le lien vers la catégorie
     */
    public function linkString() {
        $res = "<a class='categoryLink' href='#categories?categoryName=".$this->_name."' data-categoryLink='".$this->_name."'>".$this->_name."</a>";
		return $res;
    }
    /**
     * Retourne l'élément à insérer dans la gallerie pour afficher la catégorie
     */
    public function toString() {
        $res = "";
        $res .= '<li class="col-lg-2 col-md-3 col-sm-4 col-xs-6 categorie-element"><a class="categoryLink" href="#categories?categoryName='.$this->_name.'" data-categoryLink="'.$this->_name.'"><div class="categorie-image"><img src="'.$this->_categoryImage.'" alt="'.$this->_name.'"></div><div class="categorie-details"><h3 class="pull-left">'.$this->_name.'</h3>';
		if($this->_nbElements > 0) {
			$res .= '<span class="pull-right">'.$this->_nbElements.'	<i class="fa fa-picture-o" aria-hidden="true"></i></span>';
		}
		$res .= '</div></a></li>';
        return $res;
    }
}