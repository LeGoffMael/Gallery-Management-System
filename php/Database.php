<?php

/**
 * Database short summary.
 *
 * Database description.
 *
 * @version 1.0
 * @author Maël Le Goff
 */
class Database
{
	private $_db;

	public function __construct($host, $name, $encode, $user, $password)
    {
		try
		{
			// On se connecte à MySQL
			$this->_db = new PDO('mysql:host='.$host.';dbname='.$name.';charset='.$encode.'', $user, $password);
		}
		catch(Exception $e)
		{
			// En cas d'erreur, on affiche un message et on arrête tout
			die('Erreur : '.$e->getMessage());
		}
    }

	public function getDb() {
		return $this->_db;
	}

}