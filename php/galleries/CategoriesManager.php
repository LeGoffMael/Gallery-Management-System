<?php
require_once('../Settings.php');
require_once('items/Categories.php');
require_once('items/Category.php');

/**
 * CategoriesManager short summary.
 *
 * CategoriesManager description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
abstract class CategoriesManager
{
	protected $categories;

	public function __construct() {
    }

	/**
	 * Crée la gallery de categories
	 */
	abstract public function setCategories();

	/**
	 * Retourne la gallery de categories
	 * @return mixed
	 */
	public function getCategories() {
		return $this->categories;
	}
}