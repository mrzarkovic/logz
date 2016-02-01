<?php

namespace Tourizm\Model;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log_entry extends Repository {
	protected static $fields = array(
		"id" => "int",
		"date_added" => "date",
		"text" => "string",
		"parent_id" => "int"
	);

	public function __construct($row = array()) {
		var_dump("A");
		parent::__construct($row = array());

		$this->total = 0;
	}
}
