<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\base\ShipwireComponent;

class Stock extends ShipwireComponent
{

    /**
     * Gets stock of items
     * @param array $params
     * @param int $page
     * @param int $limit
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    public function getStock($params = [], $includeEmpty=false, $page = 0, $limit = 50)
    {
        if ($includeEmpty){
            $params['includeEmpty'] = 1;
        }
        return $this->get('stock', $params, $page, $limit);
    }

    /**
     * @param $skus
     * @param int $page
     * @param int $limit
     */
    public function getStockBySKUs($skus, $includeEmpty=false, $page = 0, $limit = 50)
    {
        if (is_array($skus)){
            $skus = implode(',', $skus);
        }
        $params = ['sku'=>$skus];
        if ($includeEmpty){
            $params['includeEmpty'] = 1;
        }
        return $this->get('stock', $params, $page, $limit);
    }
}