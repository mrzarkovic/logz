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
	protected static $id_field = "id";
	protected static $table_name;
	public $list = array();

	function __construct($row = array()) {
		self::$db = self::connect_to_db();
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

	/**
	 * Fetch all the records from the database
	 * and save them in the list array
	 * @throws \Exception
	 * @return bool
	 */
	public function fetchAll() {
		try {
			// Prepare sql and bind parameters
			$stmt = self::$db->prepare("SELECT * FROM " . static::$table_name);
			if ($stmt->execute()) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->list[] = new static($row);
				}
				return true;
			} else {
				return false;
			}
		} catch (\PDOException $e) {
			throw new \Exception("Error: " . $e->getMessage());
		}
	}

	/**
	 * Fetch all records where field equals value
	 * and save them in list array
	 * @param string $field_name
	 * @param string $value
	 * @return bool
	 * @throws \Exception
	 */
	public function fetchAllByFieldValue($field_name = "", $value = "") {
		try {
			$stmt = self::$db->prepare("SELECT * FROM " . static::$table_name . " WHERE `" . $field_name . "`=:value");
			$stmt->bindParam(':value', $value, static::getPdoTypeByFieldName($field_name));
			if ($stmt->execute()) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$this->list[] = new static($row);
				}
				return true;
			} else {
				return false;
			}
		} catch (\PDOException $e) {
			throw new \Exception("Error: " . $e->getMessage());
		}
	}

	/**
	 * Fetch the record from the database
	 * based on the provided id
	 * @param int $id
	 * @throws \Exception
	 * @return bool
	 */
	public function fetchById($id = 0) {
		try {
			$stmt = self::$db->prepare("SELECT * FROM " . static::$table_name . " WHERE `" . static::$id_field . "`=:id");
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			if ($stmt->execute())
				return new static($stmt->fetch(PDO::FETCH_ASSOC));
			else
				return false;
		} catch (\PDOException $e) {
			throw new \Exception("Error: " . $e->getMessage());
		}
	}

	/**
	 * Return the PDO Constant based on field type
	 * @param string $field
	 * @return int
	 */
	protected static function getPdoTypeByFieldName($field = "") {
		$field_type = static::$fields[$field];
		switch($field_type) {
			case "int":
				return PDO::PARAM_INT;
				break;
			default:
				return PDO::PARAM_STR;
		}
	}

	public function save() {
		$fields = "(";
		$values = "(";
		foreach (static::$fields as $field) {
			$fields .= "`" . $field . "`,";
			$values .= $this->$field . ",";
		}
		rtrim($fields, ",");
		rtrim($values, ",");
		$fields .= ")";
		$values .= ")";

		try {
			$stmt = self::$db->prepare("INSERT INTO " . static::$table_name . " " . $fields . " VALUES " . $values);
			if ($stmt->execute())
				return new static($stmt->fetch(PDO::FETCH_ASSOC));
			else
				return false;
		} catch (\PDOException $e) {
			throw new \Exception("Error: " . $e->getMessage());
		}
	}
}
