<?php
require_once('includes/config.php');
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

        /* All themes*/
        $this->_themes = array();
		$themes = $this->_database->getDb()->prepare("SELECT * FROM themes");
		$themes->execute();
		if($themes->rowCount() == 0)
		{
            //no theme
		}
		else{
            while ($data = $themes->fetch())
			{
                $this->addTheme(array($data['idTheme'],$data['nameTheme'],$data['mainColor'],$data['mainDarkFontColor'],$data['bodyColor'],$data['bodyFontColor'],$data['sideBarColor'],$data['sideBarFontColor'],$data['linkColor'],$data['linkHoverColor']));
            }
        }
        $themes->closeCursor();

        /* Current theme */
        $this->setTheme($result['idTheme']);
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

	//Themes management
	public function addTheme($theme) {
        array_push($this->_themes, $theme);
    }
	public function getThemes() {
        return $this->_themes;
    }
	public function setTheme($id) {
        try{
            foreach($this->_themes as $index => $theme) {
                if($theme[0] == $id)
                    $this->_theme = $this->_themes[$index];
            }
        }
        catch(Exception $e){
            exit();
        }

        $this->setThemeStyle();
    }
	public function getTheme() {
        return $this->_theme;
    }

    /**
     * Modify the config.less file
     */
    private function setThemeStyle() {
        $content = "";
        if ($this->_theme != null) {
            $content ="/* Selected theme => ".$this->_theme[1]."*/\n";
            $content .= "@mainColor : ".$this->_theme[2].";\n";
			$content .= "@mainDarkFontColor: ".$this->_theme[3].";\n";
			$content .= "@bodyColor: ".$this->_theme[4].";\n";
            $content .= "@bodyFontColor: ".$this->_theme[5].";\n";
            $content .= "@sideBarColor: ".$this->_theme[6].";\n";
			$content .= "@sideBarFontColor: ".$this->_theme[7].";\n";
			$content .= "@linkColor: ".$this->_theme[8].";\n";
            $content .= "@linkHoverColor: ".$this->_theme[9].";\n";
        }
        else {
            $content ="/* Error so => Default theme */\n";
            $content .="@mainColor : #fdd700;\n";
			$content .="@mainDarkFontColor: #000;\n";
            $content .="@bodyColor: #333;\n";
            $content .="@bodyFontColor: #fff;\n";
            $content .="@sideBarColor: #292b2c;\n";
			$content .="@sideBarFontColor: #dedede;\n";
            $content .="@linkColor: rgba(255,255,255,.5);\n";
            $content .="@linkHoverColor: #fff;\n";
        }

        try{
            $config = fopen(__DIR__ . "/../css/config.less", "w") or die("Unable to open file!");
            fwrite($config, utf8_encode($content));
            fclose($config);
        }
        catch(Exception $e){
            echo "erreur config theme";
        }
    }

	/**
	 * Return the name of all the tags in JSON
	 */
	public function getAllTags() {
	}
	/**
	 * Return the name of all the categories in JSON
	 */
	public function getAllCategories() {
	}
}