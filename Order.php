<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

/**
 * Class Order
 * @package flydreamers\shipwire
 * @author Sebastian Thierer <sebas@flydreamers.com>
 */
class Order extends ShipwireComponent
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
        return $this->get('orders', $params, $page, $limit);
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
        return $this->get($this->getRoute('orders/{id}', $orderId), $params);
    }

    /**
     * Cancels an Order
     * @param $orderId
     * @return bool
     */
    public function cancel($orderId)
    {
        $ret = $this->post($this->getRoute('orders/{id}/cancel', $orderId), [], null, true);
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
        return $this->get($this->getRoute('orders/{id}/holds', $orderId), $params, $page, $limit);
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
        return $this->get($this->getRoute('orders/{id}/items', $orderId), $params, $page, $limit);
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
        return $this->get($this->getRoute('orders/{id}/returns', $orderId), $params, $page, $limit);
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
        return $this->get($this->getRoute('orders/{id}/trackings', $orderId), $params, $page, $limit);
    }

    /**
     * Creates an order. Validates OrderData with the ModelSchema at https://www.shipwire.com/w/developers/orders/#panel-shipwire1
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function create($orderData, $params = [])
    {
        if ($this->validateOrderData($orderData)) {
            return $this->post('orders', $params, json_encode($orderData));
        }
        return false;
    }

    /**
     * Modify order details. Validates OrderData with the ModelSchema at https://www.shipwire.com/w/developers/orders/#panel-shipwire1
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function update($orderId, $orderData, $params = [])
    {
        if ($this->validateOrderData($orderData)) {
            return $this->put($this->getRoute('orders/{id}', $orderId), $params, json_encode($orderData));
        }
        return false;
    }

    /**
     * Validates Order Data using the schema at
     * @param $data
     */
    private function validateOrderData($data)
    {
        // TODO: Not working jsonSchemaValidator
        return true;
//        $retriever = new \JsonSchema\Uri\UriRetriever;
//        $filePath = __DIR__.'/schemas/create_order.json';
////        var_dump($filePath, realpath($filePath));die();
//        $schema = $retriever->retrieve('file://' . realpath($filePath));
//        $validator = new \JsonSchema\Validator();
//        $validator->check($data, $schema);
//        if ($validator->isValid()) {
//            return true;
//        } else {
//            $errors = [];
//            foreach ($validator->getErrors() as $error) {
//                $errors[] = "[".$error['property'] . "] " . $error['message'];
//            }
//            $this->errors= $errors;
//        }
    }

    /**
     * Errors related to validation errors
     * @var array
     */
    public $errors=[];

}
