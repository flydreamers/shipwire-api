<?php
require_once(dirname(dirname(__DIR__)) . '/vendor/autoload.php');

use mataluis2k\shipwire\ShipwireConnector;

$config = [
    'username' => 'test@email.com',
    'password' => 'xxxxxxxxxxxxxx',
];
$configFilePath = dirname(dirname(__DIR__)).'/local-config.php';
if (file_exists($configFilePath)){
    $config = array_merge($config, require_once($configFilePath));
}

ShipwireConnector::init($config['username'], $config['password'], 'sandbox');
