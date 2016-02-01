<?php

namespace Tourizm\Model;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends Repository {
	protected static $id_field = "id";
	protected static $fields = array(
		"name" => "string",
		"date_added" => "date"
	);
	protected static $table_name = "logs";

	public function __construct($row = array()) {
		parent::__construct($row);
	}
}
