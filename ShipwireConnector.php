<?php

namespace flydreamers\shipwire;

use flydreamers\shipwire\exceptions\ShipwireConnectionException;
use flydreamers\shipwire\exceptions\InvalidAuthorizationException;
use flydreamers\shipwire\exceptions\InvalidRequestException;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ShipwireConnector
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

    /**
     * @var LoggerInterface
     */
    static $logger;

    /**
     * Generates the connection instance for Shipwire
     *
     * @param                 $username
     * @param                 $password
     * @param null            $environment
     * @param LoggerInterface $logger
     */
    public static function init($username, $password, $environment = null, LoggerInterface $logger = null)
    {
        self::$authorizationCode = base64_encode($username . ':' . $password);
        if (null !== $environment) {
            self::$environment = $environment;
        }

        if (null === $logger) {
            $logger = new NullLogger();
        }
        self::$logger = $logger;

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
    public function api($resource, $params = [], $method = "GET", $body = null, $onlyResource = false)
    {
        $client = self::getClient();
        $request = $client->createRequest($method, '/api/v3/' . $resource, [
            'headers' => [
                'User-Agent' => 'flydreamers-shipwireapi/1.0',
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
            return $onlyResource?$data['resource']:$data;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse()->json();
            switch ($response['status']) {
                case 401:
                    throw new InvalidAuthorizationException($response['message'], $response['status']);
                    break;
                case 400:
                    throw new InvalidRequestException($response['message'], $response['status']);
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