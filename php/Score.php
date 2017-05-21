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
		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT * FROM images WHERE urlImage = :urlImage");

		$requete->bindValue(':urlImage', $url);
		$requete->execute();

		if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
			$requete->closeCursor();
		}

		$this->_idImage = $result['idImage'];
	}

	/**
	 * Vérifie si on a le droit d'effectuer le score
	 */
	public function checkIp() {
		$ip = $_SERVER['REMOTE_ADDR'];

		$ip_vote = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT * FROM ip_score WHERE ip = :ip AND idImage = :idImage");

		$ip_vote->bindValue(':ip', $ip);
		$ip_vote->bindValue(':idImage', $this->_idImage);
		$ip_vote->execute();

		if ($ip_vote->rowCount() == 0) //si l'IP n'a jamais voté
		{
			$ip_vote = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO ip_score (ip,idImage,scoreImage) VALUES (:ip, :id, :score");

			$ip_vote->bindValue(':ip', $ip);
			$ip_vote->bindValue(':id', $this->_idImage);
			$ip_vote->bindValue(':score', $this->_currentScore);
			$ip_vote->execute();

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
				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE ip_score SET
				scoreImage = :scoreImage
				WHERE ip = :ip AND idImage = :idImage");

				$requete->bindValue(':scoreImage', $this->_currentScore);
				$requete->bindValue(':ip', $ip);
				$requete->bindValue(':idImage', $this->_idImage);
				$requete->execute();

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
$score = new Score($currentScore,$urlImage);