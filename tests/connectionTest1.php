<?php
namespace flydreamers\shipwire\tests;

use flydreamers\shipwire\Address;
use flydreamers\shipwire\Rate;
use flydreamers\shipwire\ShipwireConnector;
use flydreamers\shipwire\Stock;

require_once(dirname(__DIR__) . '/vendor/autoload.php');

ShipwireConnector::setup('sebas+shipwireapi@flydreamers.com', '3c5169166c3c79e9', 'sandbox');
//$stock = new Stock();


//$stockRet = $stock->getStockBySKUs(['CAPTRACKERBLUE']);
//var_dump('Stock: ' . count($stockRet['items']));

$rate = new Rate;
$address = Address::createFromArray([
    "country" => "CA",
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
