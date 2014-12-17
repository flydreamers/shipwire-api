<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

class Orders extends ShipwireComponent
{

    public function listing($params = [], $page = 0, $limit = 50)
    {
        return $this->get('order', $params, $page, $limit);
    }

    public function orderDetails($orderId, $expand = false)
    {
        $params = [];
        if ($expand) {
            $params['expand'] = 1;
        }
        return $this->get($this->getRoute('orders/{id}', $orderId), $params);
    }

    /**
     * Cancels an Order
     * @param $orderId
     * @return bool
     */
    public function cancel($orderId)
    {
        $ret = $this->post($this->getRoute('orders/{id}/cancel', $orderId),[],null,true);
        return $ret['status']==200;
    }

    private function getRoute($route, $orderId=null)
    {
        if ($orderId!==null){
            return strtr('orders/{id}', ['{id}' => $orderId]);
        }
        return $route;
    }
}