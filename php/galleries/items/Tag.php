<?php

/**
 * Tag short summary.
 *
 * Tag description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class Tag
{
	private $_tag;

	public function __construct($tag) {
		$this->_tag = $tag;
    }

	/**
     * Retourne le lien vers les éléments ayant également ce tag
     */
    public function toString() {
        $res = "";
        $res .= "<a href='#tags?tagName=".$this->_tag."'>".$this->_tag."</a>";
        return $res;
    }
}