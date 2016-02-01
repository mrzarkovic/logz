<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$core->add_route('/', 'home@Pages');
$core->add_route('/log/(:num)', 'show@Log');