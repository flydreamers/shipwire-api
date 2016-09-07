<?php


use flydreamers\shipwire\Address;
use flydreamers\shipwire\Rate;

class RateTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testRates()
    {
        $rate = new Rate;
        $address = Address::createFromArray([
            "address1" => "6501 Railroad Avenue SE",
            "address2" => "Room 315",
            "address3" => "",
            "city" => "Snoqualmie",
            "postalCode" => "85283",
            "region" => "WA",
            "country" => "US",
            "isCommercial" => 0,
            "isPoBox" => 0
        ]);

        $shippingInfo = $rate->quote($address, [['sku' => 'CAPTRACKERBLUE', 'quantity' => 3]]);

        foreach ($shippingInfo['rates'][0]['serviceOptions'] as $shippingRate) {
            echo $shippingRate['serviceLevelName'] . ' | ' . $shippingRate['shipments'][0]['carrier']['name'];
            echo ' => ' . $shippingRate['shipments'][0]['cost']['amount'];
            echo "\n\t" . $shippingRate['shipments'][0]['carrier']['description'];
            echo "\n\t" . $shippingRate['shipments'][0]['expectedDeliveryMaxDate'];
            echo "\n";
        }
    }

}
