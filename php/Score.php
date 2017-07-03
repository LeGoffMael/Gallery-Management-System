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
	private $_url;
	private $_currentScore; //1 positive vote, 0 negative vote
	private $_idImage;
	private $_canVote;
	private $_alreadyVote;

	public function __construct($currentScore,$urlImage) {
		$this->_currentScore = $currentScore;
		$this->_url = $urlImage;
		$this->setId();
		$this->checkIp();
		$this->setScore();
    }
	/**
	 * Generates the id of the image according to its url
	 * @param mixed $url
	 */
	public function setId() {
		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT idImage FROM images WHERE urlImage = :urlImage");

		$requete->bindValue(':urlImage', $this->_url);
		$requete->execute();

		if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
			$requete->closeCursor();
		}

		$this->_idImage = $result['idImage'];
	}

	/**
	 * Check if the ip can vote
	 */
	public function checkIp() {
		$ip = $_SERVER['REMOTE_ADDR'];

		$ip_vote = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT * FROM ip_score WHERE ip = :ip AND idImage = :idImage");

		$ip_vote->bindValue(':ip', $ip);
		$ip_vote->bindValue(':idImage', $this->_idImage);
		$ip_vote->execute();

		if ($ip_vote->rowCount() == 0) //si l'IP n'a jamais voté
		{
			$insertNewIp = Settings::getInstance()->getDatabase()->getDb()->prepare("INSERT INTO ip_score (ip,idImage,valueScore,dateScore) VALUES (:ip, :id, :score, NOW())");

			$insertNewIp->bindValue(':ip', $ip);
			$insertNewIp->bindValue(':id', $this->_idImage);
			$insertNewIp->bindValue(':score', $this->_currentScore);
			$insertNewIp->execute();

			$this->_canVote = true;
		}
		else //If the IP has already voted
		{
			$vote = null;
			while ($dataIV = $ip_vote->fetch())
			{
				$vote = $dataIV['valueScore'];
			}
			$ip_vote->closeCursor();

			if ($vote == $this->_currentScore) //If he do the same vote
			{
				$this->_canVote = false;
			}
			else if ($vote != $this->_currentScore) //If he do a different vote
			{
				$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE ip_score SET
				valueScore = :valueScore, dateScore = NOW()
				WHERE ip = :ip AND idImage = :idImage");

				$requete->bindValue(':valueScore', $this->_currentScore);
				$requete->bindValue(':ip', $ip);
				$requete->bindValue(':idImage', $this->_idImage);
				$requete->execute();

				$this->_canVote = true;
				$this->_alreadyVote = true;
			}
		}
	}

	/**
	 * Update the score
	 */
	public function setScore() {
		if ($this->_currentScore == 1) {
			if ($this->_canVote == true) {
				if ($this->_alreadyVote == false) {
					$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE images SET
					scoreImage = scoreImage + 1
					WHERE idImage = :idImage");
					$requete->bindValue(':idImage', $this->_idImage);
					$requete->execute();
				}
				else if ($this->_alreadyVote == true) {
					$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE images SET
					scoreImage = scoreImage + 2
					WHERE idImage = :idImage");
					$requete->bindValue(':idImage', $this->_idImage);
					$requete->execute();
				}
			}
		}
		else if ($this->_currentScore == 0) {
			if ($this->_canVote == true) {
				if ($this->_alreadyVote == false) {
					$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE images SET
					scoreImage = scoreImage - 1
					WHERE idImage = :idImage");
					$requete->bindValue(':idImage', $this->_idImage);
					$requete->execute();
				}
				else if ($this->_alreadyVote == true) {
					$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("UPDATE images SET
					scoreImage = scoreImage - 2
					WHERE idImage = :idImage");
					$requete->bindValue(':idImage', $this->_idImage);
					$requete->execute();
				}
			}
		}
	}

	/**
	 * Return the new score of the image
	 */
	public function getScore() {
		$requete = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT scoreImage FROM images WHERE idImage = :idImage");
		$requete->bindValue(':idImage', $this->_idImage);
		$requete->execute();

		if ($result = $requete->fetch(PDO::FETCH_ASSOC)) {
			$requete->closeCursor();
		}

		return $result['scoreImage'];
	}

	/**
	 * Return the score in string
	 */
	public function getScoreString() {
		$res = "<a onClick='ControllerGallery.setVote(0,&#34;".$this->_url."&#34;);'";

		if ($this->_currentScore == 0)
			$res .= " class='active' >";
		else
			$res .= " class='' >";

		$res .= "<i class='fa fa-thumbs-down fa-flip-horizontal' aria-hidden='true'></i></a>";
		$res .= $this->getScore();
		$res .= "<a onClick='ControllerGallery.setVote(1,&#34;".$this->_url."&#34;);'";

		if ($this->_currentScore == 1)
		$res .= " class='active' >";
		else
			$res .= " class='' >";

		$res .= "<i class='fa fa-thumbs-up' aria-hidden='true'></i>";


		return $res;
	}
}

$currentScore = filter_input(INPUT_POST, 'currentVote');
$urlImage = filter_input(INPUT_POST, 'urlImage');
$score = new Score($currentScore,$urlImage);
echo $score->getScoreString();