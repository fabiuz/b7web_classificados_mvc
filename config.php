<?php
require 'environment.php';

global $config;
$config = array();

if (ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/classificados_mvc/");
	$config['dbname'] = 'classificados';
	$config['host']   = '127.0.0.1';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
} else {
	define("BASE_URL", "http://localhost/classificados_mvc/");
	$config['dbname'] = 'classificados';
	$config['host']   = '127.0.0.1';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch (PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}