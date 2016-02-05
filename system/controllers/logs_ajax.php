<?php

namespace Tourizm\Controller;

use Tourizm\Model\Log;
use Tourizm\Model\Log_entry;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Logs ajax controller
 */
class Logs_ajax extends Core
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Save the log
     * @throws \Exception
     */
    public function add_log()
    {
        $logName = $_POST['logText'];
        settype($logName, "string");
        $date = $_POST['date'];
        settype($date, "string");

        $log = new Log();
        $log->name = $logName;
        $log->date_added = new \DateTime($date);
        if ($id = $log->saveToDb())
            $this->print_ajax($id);
        else
            $this->print_ajax("false");
    }

    /**
     * Edit the log
     * @param int $logId
     * @throws \Exception
     */
    public function edit_log($logId = 0)
    {
        $logName = $_POST['logText'];
        settype($logName, "string");

        $log = new Log();
        $log = $log->fetchById($logId);
        $log->name = $logName;
        if ($id = $log->updateInDb())
            $this->print_ajax($id);
        else
            $this->print_ajax("false");
    }

    /**
     * Delete the log
     * @param int $logId
     * @throws \Exception
     */
    public function delete_log($logId = 0)
    {
        settype($logId, "integer");

        $log = new Log();
        $log = $log->fetchById($logId);
        if ($log->deleteFromDb())
            $this->print_ajax("true");
        else
            $this->print_ajax("false");
    }


    /**
     * Save the entry to a log
     * @param int $parent_id
     * @throws \Exception
     */
    public function add_entry($parent_id = 0)
    {
        $logText = $_POST['logText'];
        settype($logText, "string");
        $date = $_POST['date'];
        settype($date, "string");

        $log_entry = new Log_entry();
        $log_entry->text = $logText;
        $log_entry->parent_id = (int)$parent_id;
        $log_entry->date_added = new \DateTime($date);
        if ($id = $log_entry->saveToDb())
            $this->print_ajax($id);
        else
            $this->print_ajax("false");
    }

    /**
     * Edit the entry
     * @param int $entryId
     * @throws \Exception
     */
    public function edit_entry($entryId = 0)
    {
        $logText = $_POST['logText'];
        settype($logText, "string");

        $log_entry = new Log_entry();
        $log_entry = $log_entry->fetchById($entryId);
        $log_entry->text = $logText;
        if ($id = $log_entry->updateInDb())
            $this->print_ajax($id);
        else
            $this->print_ajax("false");
    }

    /**
     * Delete the entry
     * @param int $entryId
     * @throws \Exception
     */
    public function delete_entry($entryId = 0)
    {
        settype($entryId, "integer");

        $log_entry = new Log_entry();
        $log_entry = $log_entry->fetchById($entryId);
        if ($log_entry->deleteFromDb())
            $this->print_ajax("true");
        else
            $this->print_ajax("false");
    }

    /**
     * Load a page with ajax result
     * @param string $result
     */
    private function print_ajax($result = "")
    {
        $this->to_tpl['result'] = $result;
        $this->load_template("ajax-result");
        exit;
    }

}
