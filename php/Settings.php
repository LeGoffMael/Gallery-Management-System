<?php
require_once('functions/config.php');
require_once('Database.php');

class Settings
{
    private static $_instance; // L'attribut qui stockera l'instance unique
	private $_database;
	private $_siteTitle;
	private $_limitGallery;
	private $_language;
	private $_themes;
	private $_theme;

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new Settings();
        }
        return self::$_instance;
    }

    private function __construct() {
		$this->_database = new Database(DB_HOST, DB_NAME, DB_CHARSET, DB_USER, DB_PASSWORD);

		$settings = $this->_database->getDb()->prepare("SELECT * FROM settings");
		$settings->execute();

		if ($result = $settings->fetch(PDO::FETCH_ASSOC)) {
			$settings->closeCursor();
		}

		$this->_siteTitle = $result['title'];
		$this->_limitGallery = $result['limitGallery'];
		$this->_language = $result['language'];
    }

	//Assesseurs
    public function getDatabase() {
        return $this->_database;
    }
	public function setTitle($t) {
        $this->_siteTitle = $t;
		$requete = $this->_database->getDb()->prepare("UPDATE settings SET title = :title");
		$requete->bindValue(':title', $t);
		$requete->execute();
    }
	public function getTitle() {
        return $this->_siteTitle;
    }
	public function setLimit($l) {
		if($l < 20)
			$l = 20;
		else if ($l > 80)
			$l = 80;
        $this->_limitGallery = $l;
		$requete = $this->_database->getDb()->prepare("UPDATE settings SET limitGallery = :limitGallery");
		$requete->bindValue(':limitGallery', $l);
		$requete->execute();
    }
	public function getLimit() {
        return $this->_limitGallery;
    }
	public function setLanguage($lang) {
        $this->_language = $lang;
		$requete = $this->_database->getDb()->prepare("UPDATE settings SET language = :language");
		$requete->bindValue(':language', $lang);
		$requete->execute();
    }
	public function getLanguage() {
        return $this->_language;
    }

	//Gestion themes
	public function addTheme($theme) {
        array_push($this->_themes, $theme);
    }
	public function getThemes() {
        return $this->_themes;
    }
	public function setTheme($index) {
		$this->_theme = $this->_themes[$index];
    }
	public function getTheme() {
        return $this->_theme;
    }
}