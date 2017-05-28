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
                $this->addTheme(array($data['idTheme'],$data['nameTheme'],$data['main_color'],$data['body_color'],$data['body_font_color'],$data['main_dark_font'],$data['side_bar_color'],$data['side_bar_link_color'],$data['side_bar_link_hover_color'],$data['side_bar_font_color']));
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
            $content .= "@main_color : ".$this->_theme[2].";\n";
            $content .= "@body_color: ".$this->_theme[3].";\n";
            $content .= "@body_font_color: ".$this->_theme[4].";\n";
            $content .= "@main_dark_font: ".$this->_theme[5].";\n";
            $content .= "@side_bar_color: ".$this->_theme[6].";\n";
            $content .= "@side_bar_link_color: ".$this->_theme[7].";\n";
            $content .= "@side_bar_link_hover_color: ".$this->_theme[8].";\n";
            $content .= "@side_bar_font_color: ".$this->_theme[9].";\n";
        }
        else {
            $content ="/* Error so => Default theme */\n";
            $content .="@main_color : #fdd700;\n";
            $content .="@body_color: #333;\n";
            $content .="@body_font_color: #fff;\n";
            $content .="@main_dark_font: #000;\n";
            $content .="@side_bar_color: #292b2c;\n";
            $content .="@side_bar_link_color: rgba(255,255,255,.5);\n";
            $content .="@side_bar_link_hover_color: #fff;\n";
            $content .="@side_bar_font_color: #dedede;\n";
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
}