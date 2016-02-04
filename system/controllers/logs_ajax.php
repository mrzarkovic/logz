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

	/**
	 * Save the entry to a log
	 * @param int $parent_id
	 * @throws \Exception
	 */
	public function add_entry($parent_id = 0) {
		$logText = $_POST['logText'];
		settype($logText, "string");
		$date = $_POST['date'];
		settype($date, "string");

		$log_entry = new Log_entry();
		$log_entry->text = $logText;
		$log_entry->parent_id = (int) $parent_id;
		$log_entry->date_added = new \DateTime($date);
		if ($id = $log_entry->save())
			$this->print_ajax($id);
		else
			$this->print_ajax("fasle");
	}

	/**
	 * Edit the entry
	 * @param int $parent_id
	 * @throws \Exception
	 */
	public function edit_entry($entryId = 0) {
		$logText = $_POST['logText'];
		settype($logText, "string");

		$log_entry = new Log_entry();
		$log_entry = $log_entry->fetchById($entryId);
		$log_entry->text = $logText;
		if ($id = $log_entry->update())
			$this->print_ajax($id);
		else
			$this->print_ajax("fasle");
	}

	/**
	 * Load a page with ajax result
	 * @param string $result
	 */
	private function print_ajax($result = "") {
		$this->to_tpl['result'] = $result;
		$this->load_template("ajax-result");
		exit;
	}

}
