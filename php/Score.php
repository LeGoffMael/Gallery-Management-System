<?php
require_once('Settings.php');
/**
 * Score short summary.
 *
 * Score description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class Score
{
	private $_currentScore; //1 vote positif, 0 vote négatif
	private $_idImage;
	private $_canVote;
	private $_alreadyVote;

	public function __construct($currentScore,$urlImage) {
		$this->_currentScore = $currentScore;
		$this->setId($urlImage);
		$this->checkIp();
		$this->setScore();
    }
	/**
	 * Génére l'id de l'image en fonction de son url
	 * @param mixed $url
	 */
	public function setId($url) {
		$idImage = null;
		$id = Settings::getInstance()->getDatabase()->select(array('*'),array('images'),array('urlImage = "'.$url.'"'),null,null,null);
		while ($dataId = $id->fetch())
		{
			$idImage = $dataId['idImage'];
		}
		$id->closeCursor();
		$this->_idImage = $idImage;
	}

	/**
	 * Vérifie si on a le droit d'effectuer le score
	 */
	public function checkIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
		$ip_vote = Settings::getInstance()->getDatabase()->select(array('*'), array('ip_score'), array('ip= "'.$ip.'"','idImage= '.$this->_idImage), null, null, null);
		if ($ip_vote->rowCount() == 0) //si l'IP n'a jamais voté
		{
			//Ajout des données
			Settings::getInstance()->getDatabase()->insert('ip_score',array('ip','idImage','scoreImage'),array($ip,$this->_idImage,$this->_currentScore));
			$this->_canVote = true;
		}
		else //si l'IP à déjà voté
		{
			$vote = null;
			while ($dataIV = $ip_vote->fetch())
			{
				$vote = $dataIV['scoreImage'];
			}
			$ip_vote->closeCursor();

			if ($vote == $this->_currentScore) //si on fait le même vote
			{
				$this->_canVote = false;
			}
			else if ($vote != $this->_currentScore) //si on fait un vote différent
			{
				Settings::getInstance()->getDatabase()->update('ip_score',array('scoreImage = '.$this->_currentScore),array('ip= "'.$ip.'"','idImage = '.$this->_idImage));
				$this->_canVote = true;
				$this->_alreadyVote = true;
			}
		}
	}

	/**
	 * Met à jour le score
	 */
	public function setScore() {
		if ($this->_currentScore == 1) {
			if ($this->_canVote == true) {
				if ($this->_alreadyVote == false)
					Settings::getInstance()->getDatabase()->update('images',array('scoreImage = scoreImage + 1'),array('idImage = '.$this->_idImage));
				else if ($this->_alreadyVote == true)
					Settings::getInstance()->getDatabase()->update('images',array('scoreImage = scoreImage + 2'),array('idImage = '.$this->_idImage));
			}
		}
		else if ($this->_currentScore == 0) {
			if ($this->_canVote == true) {
				if ($this->_alreadyVote == false)
					Settings::getInstance()->getDatabase()->update('images',array('scoreImage = scoreImage - 1'),array('idImage = '.$this->_idImage));
				else if ($this->_alreadyVote == true)
					Settings::getInstance()->getDatabase()->update('images',array('scoreImage = scoreImage - 2'),array('idImage = '.$this->_idImage));
			}
		}
	}
}

$currentScore = filter_input(INPUT_GET, 'currentVote');
$urlImage = filter_input(INPUT_GET, 'urlImage');
echo 'error';
$score = new Score($currentScore,$urlImage);