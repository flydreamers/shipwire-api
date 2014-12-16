<?php
namespace flydreamers\shipwire\tests;

use flydreamers\shipwire\Address;
use flydreamers\shipwire\Rate;
use flydreamers\shipwire\ShipwireConnector;
use flydreamers\shipwire\Stock;

$config = [
    'username' => 'test@email.com',
    'password' => 'xxxxxxxxxxxxxx',
];
if (file_exists(dirname(__DIR__).'/local-config.php')){
    $config = require_once(dirname(__DIR__).'/local-config.php');
}
require_once(dirname(__DIR__) . '/vendor/autoload.php');

ShipwireConnector::setup($config['username'], $config['password'], 'sandbox');
//$stock = new Stock();


//$stockRet = $stock->getStockBySKUs(['CAPTRACKERBLUE']);
//var_dump('Stock: ' . count($stockRet['items']));

$rate = new Rate;

$address = Address::createFromArray([
    "address1" => "6501 Railroad Avenue SE",
    "address2" => "Room 315",
    "address3" => "",
    "city" => "Snoqualmie",
    "postalCode" => "85283",
    "region" => "WA",
    "country" => "MX",
    "isCommercial" => 0,
    "isPoBox" => 0
]);

$address = Address::createFromArray([
    'address1'=>'13650 NW 4th St',
    'address2'=>'Suite 201',
    'city'=>'Sunrise',
    'postalCode'=>'1115',
    'region'=>'FL',
    "country" => "AR",
]);
$items = [['sku' => 'CAPTRACKERBLUE', 'quantity' => 3]];

$shippingInfo = $rate->quote($address, [['sku' => 'CAPTRACKERBLUE', 'quantity' => 3]]);

foreach ($shippingInfo['rates'][0]['serviceOptions'] as $shippingRate) {
//    var_dump($shippingRate);
    echo $shippingRate['serviceLevelName'] . ' | ' . $shippingRate['shipments'][0]['carrier']['name'];
    echo ' => ' . $shippingRate['shipments'][0]['cost']['amount'];
    echo "\n\t" . $shippingRate['shipments'][0]['carrier']['description'];
    echo "\n\t" . $shippingRate['shipments'][0]['expectedDeliveryMaxDate'];
    echo "\n";
}
