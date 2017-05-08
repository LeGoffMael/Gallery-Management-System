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

	/**
	 * SELECT les paramètres
	 * @param mixed $fields tableau
	 * @param mixed $froms tableau
	 * @param mixed $wheres tableau
	 * @param mixed $groupby
	 * @param mixed $orderby
	 * @param mixed $limit
	 */
	public function select($fields, $froms, $wheres, $groupby, $orderby, $limit) {
		$query = 'SELECT ';

		foreach ($fields as $field) {
			$query .= $field . ",";
		}

		$query = substr($query, 0, strlen($query)-1);
		$query .= ' FROM ';

		foreach ($froms as $from) {
			$query .= $from . ",";
		}
		$query = substr($query, 0, strlen($query)-1);

		if($wheres != null) {
			$query .= ' WHERE ';

			foreach ($wheres as $where) {
				$query .= $where . " AND ";
			}

			$query = substr($query, 0, strlen($query)-5);
		}

		if($groupby != null) {
			$query .= " GROUP BY ".$groupby;
		}

		if($orderby != null) {
			$query .= " ORDER BY ".$orderby;
		}

		if($limit != null) {
			$query .= " LIMIT ".$limit;
		}

		return $this->_db->query($query);
	}

	/**
	 * INSERT les paramètres
	 * @param mixed $table
	 * @param mixed $sets tableau
	 * @param mixed $conditions tableau
	 */
	public function insert($table, $columns, $params) {
		$query = "INSERT INTO ".$table." (";

		foreach ($columns as $column) {
			$query .= $column . ",";
		}
		$query = substr($query, 0, strlen($query)-1);
		$query .= ")";

	    $query .= " VALUES (";

		foreach ($params as $param) {
			$query .= "'".$param . "',";
		}
		$query = substr($query, 0, strlen($query)-1);
		$query .= ")";

		$this->_db->exec($query);
	}

	/**
	 * UPDATE les paramètres
	 * @param mixed $table
	 * @param mixed $sets tableau
	 * @param mixed $conditions tableau
	 */
	public function update($table, $sets, $conditions) {
		$query = 'UPDATE '. $table .' SET ';

		foreach ($sets as $set) {
			$query .= $set . ",";
		}

		$query = substr($query, 0, strlen($query)-1);

		if($conditions != null) {
		$query .= ' WHERE ';
			foreach ($conditions as $condition) {
				$query .= $condition . " AND ";
			}
			$query = substr($query, 0, strlen($query)-5);
		}

		try
		{
			$this->_db->exec($query);
			echo $query;
		}
		catch(Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}

	}

	/**
	 * DELETE les paramètres
	 * @param mixed $table
	 * @param mixed $sets tableau
	 * @param mixed $conditions tableau
	 */
	public function delete($table, $conditions) {
		$query = 'DELETE FROM '. $table;

		if($conditions != null) {
			$query .= ' WHERE ';
			foreach ($conditions as $condition) {
				$query .= $condition . " AND ";
			}
			$query = substr($query, 0, strlen($query)-5);
		}

		$this->_db->query($query);
	}
}