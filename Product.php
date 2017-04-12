<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

/**
 * Class Order
 *
 * @package flydreamers\shipwire
 * @author  Sebastian Thierer <sebas@flydreamers.com>
 */
class Product extends ShipwireComponent
{
    /**
     * Gets product details
     *
     * @param  int  $id
     * @param  bool $expand
     * @return array
     */
    public function productDetails($id, $expand = false)
    {
        $params = [];

        if ($expand) {
            $params['expand'] = 'all';
        }

        return $this->get($this->getRoute('products/{id}', $id), $params);
    }

    /**
     * Transform the route with the given id
     *
     * @param  string   $route
     * @param  int|null $orderId
     * @return string
     */
    private function getRoute($route, $orderId = null)
    {
        if ($orderId !== null) {
            return strtr($route, ['{id}' => $orderId]);
        }

        return $route;
    }
}
