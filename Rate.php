<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

class Rate extends ShipwireComponent
{
    /**
     *
     * @param Address $address
     * @param array $items
     */
    public function quote(Address $address, $items = [], $options = null)
    {
        if ($options == null) {
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