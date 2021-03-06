<?php
require_once('Category.php');
require_once('Tag.php');

/**
 * Image short summary.
 *
 * Image description.
 *
 * @version 1.0
 * @author Ma�l Le Goff
 */
class Image
{
	private $_url;
    private $_description;
    private $_categories;
    private $_tags;
    private $_score;
	private $_upActive;
	private $_downActive;

	public function __construct($url,$description,$categories,$tags,$score,$up,$down) {
		$this->_url = $url;
		$this->_description = $description;
		if($description == "") {
			$this->_description = "no description";
		}
		$this->_categories = $categories;
		$this->_tags = $tags;
		$this->_score = $score;
		$this->_upActive = $up;
		$this->_downActive = $down;
    }

	/**
	 * Retourne une chaine contenant l'affichage du score
	 * @return string
	 */
	public function scoreToString() {
		$res = "<a data-typeVote='0' data-voteUrl='".$this->_url."' class='voteButton";

		if ($this->_downActive == false)
		$res .= "' >";
		else
			$res .= " active' >";

		$res .= "<i class='fa fa-thumbs-down fa-flip-horizontal' aria-hidden='true'></i></a>";
		$res .= $this->_score ;
		$res .= "<a data-typeVote='1' data-voteUrl='".$this->_url."' class='voteButton";

		if ($this->_upActive == false)
			$res .= "' >";
		else
			$res .= " active' >";

		$res .= "<i class='fa fa-thumbs-up' aria-hidden='true'></i>";
		return $res;
	}
	/**
     * Retourne une chaine contenant tous les noms de categeries auxquels appartient l'image
     */
    public function categoriesToString() {
        $res = "";
        for ($i = 0; $i < count($this->_categories); $i++) {
            if ($res != "") {
                $res .= ' ; ';
            }
            $res .= $this->_categories[$i]->linkString();
        }
        return $res;
    }
	/**
     * Retourne une chaine contenant tous les noms de tags li�s l'image
     */
    public function tagsToString() {
        $res = "";
        for ($i = 0; $i < count($this->_tags); $i++) {
            if ($res != "") {
                $res .= " ; ";
            }
            $res .= $this->_tags[$i]->toString();
        }
        return $res;
    }

	/**
     * Retourne la chaine � afficher dans la gallery
     */
    public function toString() {
        $res = "";
        $res .= '<a class="col-md-4" href="'.$this->_url.'" data-categories="'.$this->categoriesToString().'" data-tags="'.$this->tagsToString().'" data-score="'.$this->scoreToString().'">';
		$res .= '<img src="'.$this->_url.'" class="img-fluid" alt="'.$this->_url.'"/><figure>'.$this->_description.'</figure></a>';
		return $res;
    }
}