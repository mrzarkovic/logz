<?php

namespace Tourizm\Controller;

use Tourizm\Model\Log_entry;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logs ajax controller
 */
class Logs_ajax extends Core {
	public function __construct() {
		parent::__construct();
	}

	public function add_entry($parent_id = 0) {
		$logText = $_POST['logText'];
		settype($logText, "string");

		$log_entry = new Log_entry();
		$log_entry->text = $logText;
		$log_entry->parent_id = (int) $parent_id;
		$now = new \DateTime("now");
		$log_entry->date_added = $now->format("d-m-Y H:i:s");
		$log_entry->save();

		$this->print_ajax("rezultat");
	}

	private function print_ajax($result = "") {
		$this->to_tpl['result'] = $result;
		$this->load_template("ajax-result");
		exit;
	}

}
