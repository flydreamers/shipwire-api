<?php

namespace mataluis2k\shipwire;

use mataluis2k\shipwire\base\ShipwireComponent;

/**
 * Class Order
 * @package mataluis2k\shipwire
 * @author Sebastian Thierer <sebas@mataluis2k.com>
 */
class purchaseOrders extends ShipwireComponent
{
    /**
     * Lists all orders depending on your parameters.
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function listing($params = [], $page = 0, $limit = 50)
    {
        return $this->get('purchaseOrders', $params, $page, $limit);
    }

    /**
     * Gets order details
     * @param $orderId
     * @param bool $expand
     * @return array
     */
    public function orderDetails($orderId, $expand = false)
    {
        $params = [];
        if ($expand) {
            $params['expand'] = 'all';
        }
        return $this->get($this->getRoute('purchaseOrders/{id}', $orderId), $params);
    }

    /**
     * Cancels an Order
     * @param $orderId
     * @return bool
     */
    public function cancel($orderId)
    {
        $ret = $this->post($this->getRoute('purchaseOrders/{id}/cancel', $orderId), [], null, true);
        return $ret['status'] == 200;
    }

    /**
     * Transform the route with the given orderId
     * @param $route
     * @param null $orderId
     * @return string
     */
    private function getRoute($route, $orderId = null)
    {
        if ($orderId !== null) {
            return strtr($route, ['{id}' => $orderId]);
        }
        return $route;
    }


    /**
     * Get the list of holds, if any, on an order
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function holds($orderId, $includeCleared = false, $params = [], $page = 0, $limit = 50)
    {
        if (!isset($params['includeCleared'])) {
            $params['includeCleared'] = $includeCleared ? 1 : 0;
        }
        return $this->get($this->getRoute('purchaseOrders/{id}/holds', $orderId), $params, $page, $limit);
    }


    /**
     * Get the product details for this order
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function items($orderId, $params = [], $page = 0, $limit = 50)
    {
        return $this->get($this->getRoute('purchaseOrders/{id}/items', $orderId), $params, $page, $limit);
    }


    /**
     * Get related return information for a specific order.
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function returns($orderId, $params = [], $page = 0, $limit = 50)
    {
        return $this->get($this->getRoute('purchaseOrders/{id}/returns', $orderId), $params, $page, $limit);
    }


    /**
     * Get tracking information for a specific order.
     * @param $orderId
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function tracking($orderId, $params = [], $page = 0, $limit = 50)
    {
        return $this->get($this->getRoute('purchaseOrders/{id}/trackings', $orderId), $params, $page, $limit);
    }

    /**
     * Creates an order.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function create($orderData, $params = [])
    {
        return $this->post('purchaseOrders', $params, json_encode($orderData), false);
    }

    /**
     * Modify order details.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function update($orderId, $orderData, $params = [])
    {
        return $this->put($this->getRoute('purchaseOrders/{id}', $orderId), $params, json_encode($orderData));
    }

    /**
     * Errors related to validation errors
     * @var array
     */
    public $errors=[];
}
