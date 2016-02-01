<?php

namespace Tourizm\Model;

use \PDO;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Repository model
 */
class Repository {

	protected static $db;
	protected static $fields;
	protected static $id_field;
	protected static $table_name;
	public $list = array();

	function __construct($row = array()) {
		$id_field = static::$id_field;
		$this->$id_field = (int) (isset($row[static::$id_field]) ? $row[static::$id_field] : 0);

		foreach (static::$fields as $field => $type) {
			if (!isset($this->$field)) $this->$field = null;
			if ($type == "int") $this->$field = (int)(isset($row[$field]) ? $row[$field] : 0);
			else if ($type == "string") $this->$field = (isset($row[$field]) ? $row[$field] : "");
			else if ($type == "date") $this->$field = (isset($row[$field]) ? new \DateTime($row[$field]) : new \DateTime("now"));
		}
	}

	/**
	 * Connect to a database
	 * @return PDO connection
	 */
	private static function connect_to_db() {
		// Database connection
		$db_user = "root";
		$db_pass = "";
		$hostname = "localhost";
		$db_name = "logz";

		$db = new PDO('mysql:host=' . $hostname . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
		// set the PDO error mode to exception
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $db;
	}

	public function fetchAll() {
		try {
			self::$db = self::connect_to_db();
			// prepare sql and bind parameters
			$stmt = self::$db->prepare("SELECT * FROM logs");
			$stmt->bindParam(':tablename', self::$table_name, PDO::PARAM_STR);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->list[] = new static($row);
			}
		} catch (PDOException $e) {
			throw new Exception("Error: " . $e->getMessage());
		}
	}

	public function fetchById($id = 0) {
		//
	}

}
