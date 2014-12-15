<?php
namespace flydreamers\shipwire\tests;

use flydreamers\shipwire\ShipwireConnector;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

ShipwireConnector::setup('sebas+shipwireapi@flydreamers.com', '3c5169166c3c79e9', 'sandbox');
$conn = ShipwireConnector::getInstance();


var_dump($conn->api('stock',['includeEmpty'=>1]));


