<?php

namespace Tourizm\Model;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_entry extends Repository {
	protected static $fields = array(
		"date_added" => "date",
		"text" => "string",
		"parent_id" => "int"
	);
	protected static $table_name = "log_entries";

	public function __construct($row = array()) {
		parent::__construct($row);
	}
}
