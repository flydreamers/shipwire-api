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
    protected $_connector;

    /**
     * Sets internal settings
     */
    public function __construct()
    {
        $this->_connector = ShipwireConnector::getInstance();
    }

    /**
     * @param $route
     * @param $params
     * @param int $page
     * @param int $limit
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    protected function get($route, $params, $page=0, $limit=50){
        if ($page!=false){
            $limit = max(1,min($limit,100));
            $page = max(0,$page);
            $params['offset'] = $page * $limit;
            $params['limit'] = $limit;
        }
        return $this->_connector->api($route, $params, ShipwireConnector::GET);
    }

    /**
     * @param $route
     * @param $params
     * @param int $page
     * @param int $limit
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    protected function post($route, $params, $body, $onlyResource=false){
        return $this->_connector->api($route, $params, ShipwireConnector::POST, $body, $onlyResource);
    }

    /**
     * @param $route
     * @param $params
     * @param int $page
     * @param int $limit
     * @throws \Exception
     * @throws \flydreamers\shipwire\exceptions\InvalidAuthorizationException
     * @throws \flydreamers\shipwire\exceptions\InvalidRequestException
     * @throws \flydreamers\shipwire\exceptions\ShipwireConnectionException
     */
    protected function put($route, $params, $body){
        return $this->_connector->api($route, $params, ShipwireConnector::PUT, $body);
    }
}
