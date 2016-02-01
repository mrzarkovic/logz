<?php

namespace Tourizm\Controller;
use Tourizm\Model\Log;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Page controller
 */
class Pages extends Core {
	public function __construct() {
		parent::__construct();
	}

	public function home() {
		$logs = new Log();
		$logs->fetchAll();

		$this->to_tpl['logs'] = $logs;
		$this->template = "home";
	}

}
