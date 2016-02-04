<?php

namespace Tourizm\Controller;
use Tourizm\Model\Log;
use Tourizm\Model\Log_entry;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logs controller
 */
class Logs extends Core {
	public function __construct() {
		parent::__construct();
	}

	public function show($id = 0) {
		$log = new Log();
		$log = $log->fetchById($id);

		$log_entries = new Log_entry();
		$log_entries->fetchAllByFieldValue("parent_id", $id);

		$this->to_tpl['log'] = $log;
		$this->to_tpl['log_entries'] = $log_entries->list;
		$this->template = "log";

		return;
	}

}
