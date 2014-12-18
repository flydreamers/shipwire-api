<?php


class OrdersTest extends \Codeception\TestCase\Test
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

    public function testOrderList()
    {
        $order = $this->getOrder();
        var_dump($order->tracking(42037534)); die();
        return;
//        var_dump($order->listing(['expand' => true]));die();

        $data = json_decode('
    {
    "orderNo": "foobar1",
    "externalId": "rFooBar1",
    "processAfterDate": "2014-12-20T16:30:00-07:00",
    "commerceName": "Fly dreamers",
    "items": [
        {
            "sku": "CAPTRACKERBLUE",
            "quantity": 2,
            "commercialInvoiceValue": 10,
            "commercialInvoiceValueCurrency": "USD"
        },
    ],
    "options": {
        "warehouseId": null,
        "warehouseExternalId": null,
        "warehouseRegion": "US",
        "warehouseArea": null,
        "serviceLevelCode": "1D",
        "carrierCode": null,
        "sameDay": "NOT REQUESTED",
        "channelName": "My Channel",
        "forceDuplicate": 0,
        "forceAddress": 0,
        "referrer": "Foo Referrer",
        "affiliate": null,
        "currency": "USD",
        "canSplit": 1,
        "hold": 1,
        "forceAsync": 0,
    },
    "shipTo": {
    "email": "audrey . horne@greatnothern . com",
        "name": "Audrey Horne",
        "company": "Audreys Bikes",
        "address1": "6501 Railroad Avenue SE",
        "address2": "Room 315",
        "address3": "",
        "city": "Snoqualmie",
        "state": "WA",
        "postalCode": "98065",
        "country": "US",
        "phone": "4258882556",
        "isCommercial": 0,
        "isPoBox": 0
    }
}
');

        $order->create([

    "orderNo" => "foobar1",
    "externalId" => "rFooBar1",
    "processAfterDate" => "2014-12-20T16:30:00-07:00",
    "commerceName" => "Fly dreamers",
    "items" => [
        [
            "sku" => "CAPTRACKERBLUE",
            "quantity" => 2,
            "commercialInvoiceValue" => 10,
            "commercialInvoiceValueCurrency" => "USD"
        ]
    ],
    "options" => [
        "warehouseId" => null,
        "warehouseExternalId" => null,
        "warehouseRegion" => "US",
        "warehouseArea" => null,
        "serviceLevelCode" => "1D",
        "carrierCode" => null,
        "sameDay" => "NOT REQUESTED",
        "channelName" => "My Channel",
        "forceDuplicate" => 0,
        "forceAddress" => 0,
        "referrer" => "Foo Referrer",
        "affiliate" => null,
        "currency" => "USD",
        "canSplit" => 1,
        "hold" => 1,
        "forceAsync" => 0,
    ],
    "shipTo" => [
        "email" => "audrey . horne@greatnothern . com",
        "name" => "Audrey Horne",
        "company" => "Audreys Bikes",
        "address1" => "6501 Railroad Avenue SE",
        "address2" => "Room 315",
        "address3" => "",
        "city" => "Snoqualmie",
        "state" => "WA",
        "postalCode" => "98065",
        "country" => "US",
        "phone" => "4258882556",
        "isCommercial" => 0,
        "isPoBox" => 0
    ]
]);
    }

    /**
     * Get an order
     * @return \flydreamers\shipwire\Order
     */
    private function getOrder()
    {
        $order = new \flydreamers\shipwire\Order();
        return $order;
    }

}