<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!isset($config['database_tables'])){
	$config['database_tables'] = new stdClass();
}
$config['database_tables']->auth       			= new stdClass();

$config['database_tables']->auth->user 			= 'users';
$config['database_tables']->auth->sessions 		= 'sessions';
$config['database_tables']->auth->denied_access 	= 'logs';

/* End of file db_tables.php */