<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

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
            return strtr('orders/{id}', ['{id}' => $orderId]);
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

    public function create($orderData, $params = [])
    {
        if ($this->validateOrderData($orderData)) {
            return $this->post('orders', $params, json_encode($orderData),false);
        }
        return false;
    }

    private function validateOrderData($data)
    {
        $schema = json_decode(self::SCHEMA_STR);
        $validator = new \JsonSchema\Validator();
        if ($validator->isValid()) {
            return true;
        } else {
            $errors = [];
            foreach ($validator->getErrors() as $error) {
                $errors[] = "[".$error['property'] . "] " . $error['message'];
            }
            $this->errors= $errors;
        }
    }
    public $errors=[];


    /*
PUT	/api/v3/orders/{id}
Modify order details.
     */

    const SCHEMA_STR = '{
    "properties": {
        "externalId": {
            "type": "string"
        },
        "commerceName": {
            "type": "string"
        },
        "orderNo": {
            "type": "string"
        },
        "processAfterDate": {
            "type": "string"
        },
        "commercialInvoice": {
            "properties": {
                "additionalValue": {
                    "type": "number"
                },
                "additionalValueCurrency": {
                    "type": "string"
                },
                "insuranceValue": {
                    "type": "number"
                },
                "insuranceValueCurrency": {
                    "type": "string"
                },
                "shippingValue": {
                    "type": "number"
                },
                "shippingValueCurrency": {
                    "type": "string"
                }
            },
            "required": [
            ],
            "type": ["object", "null"]
        },
        "items": {
            "items": [
                {
                    "properties": {
                        "commercialInvoiceValue": {
                            "type": "number"
                        },
                        "commercialInvoiceValueCurrency": {
                            "type": "string"
                        },
                        "quantity": {
                            "type": "integer"
                        },
                        "sku": {
                            "type": "string"
                        }
                    },
                    "required": [
                        "sku",
                        "quantity"
                    ],
                    "type": "object"
                }
            ],
            "type": "array"
        },
        "options": {
            "properties": {
                "affiliate": {
                    "type": "string"
                },
                "canSplit": {
                    "type": "integer"
                },
                "carrierCode": {
                    "type": "string"
                },
                "currency": {
                    "type": "string"
                },
                "discountCode": {
                    "type": "string"
                },
                "forceAddress": {
                    "type": "integer"
                },
                "forceAsync": {
                    "type": "integer"
                },
                "forceDuplicate": {
                    "type": "integer"
                },
                "channelName": {
                    "type": "string"
                },
                "hold": {
                    "type": "integer"
                },
                "referrer": {
                    "type": "string"
                },
                "sameDay": {
                    "type": "integer"
                },
                "server": {
                    "type": "string"
                },
                "serviceLevelCode": {
                    "type": "string"
                },
                "warehouseId": {
                    "type": "integer"
                },
                "warehouseExternalId": {
                    "type": "string"
                },
                "warehouseRegion": {
                    "type": "string"
                },
                "warehouseArea": {
                    "type": "string"
                }
            },
            "required": [
            ],
            "type": "object"
        },
        "packingList": {
            "properties": {
                "message1": {
                    "properties": {
                        "body": {
                            "type": "string"
                        },
                        "header": {
                            "type": "string"
                        }
                    },
                    "required": [
                        "body",
                        "header"
                    ],
                    "type": ["null", "object"]
                },
                "message2": {
                    "properties": {
                        "body": {
                            "type": "string"
                        },
                        "header": {
                            "type": "string"
                        }
                    },
                    "required": [
                        "body",
                        "header"
                    ],
                    "type": ["null", "object"]
                },
                "message3": {
                    "properties": {
                        "body": {
                            "type": "string"
                        },
                        "header": {
                            "type": "string"
                        }
                    },
                    "required": [
                        "body",
                        "header"
                    ],
                    "type": ["null", "object"]
                },
                "other": {
                    "properties": {
                        "body": {
                            "type": "string"
                        },
                        "header": {
                            "type": "string"
                        }
                    },
                    "required": [
                        "body",
                        "header"
                    ],
                    "type": ["null", "object"]
                }
            },
            "required": [
            ],
            "type": ["null", "object"]
        },
        "shipFrom": {
            "properties": {
                "company": {
                    "type": "string"
                }
            },
            "required": [
            ],
            "type": ["null", "object"]
        },
        "shipTo": {
            "properties": {
                "address1": {
                    "type": "string"
                },
                "address2": {
                    "type": "string"
                },
                "address3": {
                    "type": "string"
                },
                "city": {
                    "type": "string"
                },
                "country": {
                    "type": "string"
                },
                "email": {
                    "type": "string"
                },
                "isCommercial": {
                    "type": "integer"
                },
                "isPoBox": {
                    "type": "integer"
                },
                "name": {
                    "type": "string"
                },
                "company": {
                    "type": "string"
                },
                "phone": {
                    "type": "string"
                },
                "postalCode": {
                    "type": "string"
                },
                "state": {
                    "type": "string"
                }
            },
            "required": [
                "name",
                "address1",
                "city",
                "state",
                "email",
                "postalCode",
                "country",
                "phone",
            ],
            "type": "object"
        }
    },
    "required": [
        "items",
        "shipTo",
    ],
    "type": "object"
}';
}