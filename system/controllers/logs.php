<?php

namespace Tourizm\Controller;
use Tourizm\Model\Log_entry;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Page controller
 */
class Logs extends Core {
	public function __construct() {
		parent::__construct();
	}

	public function show($id = 0) {
		$log = new Log_entry();
		$log->fetchById($id);

		$this->to_tpl['log'] = $log;
		$this->template = "home";
	}

}
