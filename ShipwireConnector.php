<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\exceptions\ShipwireConnectionException;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;

class ShipwireConnector //extends Shipwire
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';


    /**
     * Environment method for integration. Possible values: 'live', 'sandbox'
     * @var string
     */
    static $environment = 'live';

    /**
     * Sandbox Base Url for Shipwire API
     * @var string
     */
    static $sandboxBaseUrl = 'https://api.beta.shipwire.com';

    /**
     * Live Base Url for Shipwire API
     * @var string
     */
    static $baseUrl = 'https://api.shipwire.com';

    /**
     * @var string
     */
    static $authorizationCode;

    /**
     * @var string
     */
    static $version = 'v3';

    private function __construct()
    {
    }

    /**
     * Generates the connection instance for Shipwire
     *
     * @param $username
     * @param $password
     * @param string $environment
     * @param string $version
     * @throws Exception
     */
    public static function init($username, $password, $environment = null)
    {
        self::$authorizationCode = base64_encode($username . ':' . $password);
        if (self::$environment !== null) {
            self::$environment = $environment;
        }
        self::$instance = null;
    }

    /**
     * @var ShipwireConnector
     */
    private static $instance = null;

    /**
     * @return ShipwireConnector
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
            self::$instance->getClient();
        }
        return self::$instance;
    }

    /**
     * @var Client
     */
    private $_client;

    /**
     * Gets guzzle client to manage URL Connections
     *
     * @return Client
     */
    private function getClient()
    {
        if (!isset($this->client)) {
            if (!isset(self::$authorizationCode)) {
                throw new \Exception('Invalid authorization code');
            }
            $this->client = new Client(
                [
                    'base_url' => self::getEndpointUrl(),
                ]
            );
        }
        return $this->client;
    }

    /**
     * Send an api request to Shipwire Endpoint
     * @param string $resource function to be called
     * @param array $params key value parameters
     * @param string $method
     * @param string $body
     *
     * @throws Exception
     */
    public function api($resource, $params = [], $method = "GET", $body = null)
    {
        $client = self::getClient();
        $request = $client->createRequest($method, '/api/v3/' . $resource, [
            'headers' => [
                'User-Agent' => 'shipwire-connector/1.0',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . self::$authorizationCode
            ],
            'body'=>$body
        ]);
        if (count($params) > 0) {
            $request->setQuery($params);
        }
        if ($body!==null){
            $request->addHeader('content-type', 'application/json');
        }
        try {
            $response = $client->send($request);
            $data = $response->json();
            if ($data['status'] >= 300) {
                throw new ShipwireConnectionException($data['message'], $data['status']);
            }
            return $data['resource'];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse()->json();
            var_dump($response); die();
            switch ($response['status']) {
                case 401:
                    throw new \flydreamers\shipwire\exceptions\InvalidAuthorizationException($response['message'], $response['status']);
                    break;
                case 400:
                    throw new \flydreamers\shipwire\exceptions\InvalidRequestException($response['message'], $response['status']);
                    break;
            }
            throw new ShipwireConnectionException($response['message'], $response['status']);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Gets the endpoint URL based on
     * @return string
     */
    protected static function getEndpointUrl()
    {
        if (self::$environment == 'live') {
            return self::$baseUrl;
        }
        return self::$sandboxBaseUrl;
    }
}