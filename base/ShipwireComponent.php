<?php

namespace flydreamers\shipwire\base;

use flydreamers\shipwire\ShipwireConnector;


/**
 * Class ShipwireComponent
 *
 * @package flydreamers\shipwire\base
 * @author Sebastian Thierer <sebas@flydreamers.com>
 *
 */
class ShipwireComponent
{
    /**
     * @var ShipwireConnector
     */
    private $_connector;

    /**
     * Sets internal settings
     */
    public function __construct()
    {
        $this->_connector = ShipwireConnector::getInstance();
    }

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
    public function getStock($params=[], $page=0, $limit=50)
    {
        return $this->_connector->api('stock',$params, ShipwireConnector::GET);
    }
}