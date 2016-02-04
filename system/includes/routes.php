<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Show Logs
$core->add_route('/', 'home@Pages');
// Show Log
$core->add_route('/log/(:num)', 'show@Logs');
// Ajax Logs
$core->add_route('/log/ajax/add-log', 'add_log@Logs_ajax');
$core->add_route('/log/ajax/edit-log/(:num)', 'edit_log@Logs_ajax');
// Ajax Entries
$core->add_route('/log/ajax/add-entry/(:num)', 'add_entry@Logs_ajax');
$core->add_route('/log/ajax/edit-entry/(:num)', 'edit_entry@Logs_ajax');