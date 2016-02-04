<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$core->add_route('/', 'home@Pages');
$core->add_route('/log/(:num)', 'show@Logs');
$core->add_route('/log/ajax/add-entry/(:num)', 'add_entry@Logs_ajax');
$core->add_route('/log/ajax/edit-entry/(:num)', 'edit_entry@Logs_ajax');