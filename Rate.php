<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

class Rate extends ShipwireComponent
{
    /**
     * Get a quote for a shippment of $items to $address. $options could be changed for different use cases.
     *
     * @param Address $address
     * @param array $items [['sku' => 'CAPTRACKERBLUE', 'quantity' => 3]]
     * @param array $options for example: ["currency" => "USD", "groupBy" => "all", "canSplit" => 1, "warehouseArea" => "US"]
     */
    public function quote(Address $address, $items = [], $options = [])
    {
        if (count($options)==0) {
            $options = [
                "currency" => "USD",
                "groupBy" => "all",
                "canSplit" => 1,
                "warehouseArea" => "US"
            ];
        }
        $json = json_encode([
            'options' => $options,
            'order'=>[
                'shipTo'=>$address->asArray(),
                'items'=>$items,
            ]
        ]);
        return $this->post('rate', [], $json);
    }
}