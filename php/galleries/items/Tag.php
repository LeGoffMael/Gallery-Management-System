<?php

/**
 * Tag short summary.
 *
 * Tag description.
 *
 * @version 1.0
 * @author Ma�l Le Goff
 */
class Tag
{
	private $_tag;

	public function __construct($tag) {
		$this->_tag = $tag;
    }

	/**
     * Retourne le lien vers les �l�ments ayant �galement ce tag
     */
    public function toString() {
        $res = "";
        $res .= "<a href='#tags?tagName=".$this->_tag."'>".$this->_tag."</a>";
        return $res;
    }
}