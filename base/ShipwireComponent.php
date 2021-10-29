<?php

namespace mataluis2k\shipwire\base;

use mataluis2k\shipwire\ShipwireConnector;


/**
 * Class ShipwireComponent
 *
 * @package mataluis2k\shipwire\base
 * @author Sebastian Thierer <sebas@mataluis2k.com>
 * @version
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
     * @param string $route
     * @param array $params
     * @param int $page
     * @param int $limit
     * @return array
     * @throws \Exception
     * @throws \mataluis2k\shipwire\exceptions\InvalidAuthorizationException
     * @throws \mataluis2k\shipwire\exceptions\InvalidRequestException
     * @throws \mataluis2k\shipwire\exceptions\ShipwireConnectionException
     */
    protected function get($route, $params, $page=0, $limit=50){
        if ($page!=false){
            $limit = max(1,min($limit,100));
            $page = max(0,$page);
            $params['offset'] = $page * $limit;
            $params['limit'] = $limit;
        }
        return $this->_connector->api($route, $params, ShipwireConnector::GET, null, true);
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $body
     * @param bool $onlyResource
     * @return array
     * @throws \Exception
     * @throws \mataluis2k\shipwire\exceptions\InvalidAuthorizationException
     * @throws \mataluis2k\shipwire\exceptions\InvalidRequestException
     * @throws \mataluis2k\shipwire\exceptions\ShipwireConnectionException
     */
    protected function post($route, $params, $body, $onlyResource=true){
        return $this->_connector->api($route, $params, ShipwireConnector::POST, $body, $onlyResource);
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $body
     * @param bool $onlyResource
     * @return array
     * @throws \Exception
     * @throws \mataluis2k\shipwire\exceptions\InvalidAuthorizationException
     * @throws \mataluis2k\shipwire\exceptions\InvalidRequestException
     * @throws \mataluis2k\shipwire\exceptions\ShipwireConnectionException
     */
    protected function put($route, $params, $body, $onlyResource=true){
        return $this->_connector->api($route, $params, ShipwireConnector::PUT, $body,$onlyResource);
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $body
     * @param bool $onlyResource
     * @return array
     * @throws \Exception
     * @throws \mataluis2k\shipwire\exceptions\InvalidAuthorizationException
     * @throws \mataluis2k\shipwire\exceptions\InvalidRequestException
     * @throws \mataluis2k\shipwire\exceptions\ShipwireConnectionException
     */
    protected function delete($route, $params, $onlyResource=true){
        return $this->_connector->api($route, $params, ShipwireConnector::DELETE, $onlyResource);
    }
}
