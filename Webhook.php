<?php

namespace mataluis2k\shipwire;

use mataluis2k\shipwire\base\ShipwireComponent;

/**
 * Class Order
 * @package mataluis2k\shipwire
 * @author Sebastian Thierer <sebas@mataluis2k.com>
 */
class Webhook extends ShipwireComponent
{
    /**
     * Lists all webhooks depending on your parameters.
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function listing($params = [], $page = 0, $limit = 50)
    {
        return $this->get('webhooks', $params, $page, $limit);
    }

    /**
     * Gets order details
     * @param $orderId
     * @param bool $expand
     * @return array
     */
    public function details($webhookId, $expand = false)
    {
        $params = [];
        if ($expand) {
            $params['expand'] = 'all';
        }
        return $this->get($this->getRoute('webhooks/{id}', $webhookId), $params);
    }

    /**
     * Creates an order.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function create($data, $params = [])
    {
        return $this->post('webhooks', $params, json_encode($data));
    }

    /**
     * Modify order details.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function update($webhookId, $data, $params = [])
    {
        return $this->put($this->getRoute('webhooks/{id}', $webhookId), $params, json_encode($data));
    }

    /**
     * Modify order details.
     * @param $orderData
     * @param array $params
     * @return array|bool
     */
    public function unsubscribe($webhookId, $params = [])
    {
        return $this->delete('webhooks/'.$webhookId, $params);
    }

    /**
     * Errors related to validation errors
     * @var array
     */
    public $errors=[];
}
