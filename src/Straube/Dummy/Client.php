<?php

namespace Straube\Dummy;

use GuzzleHttp\Client as Http;

/**
 * Dummy API implementation.
 *
 * @version 1.0.0
 * @author  Gustavo Straube
 */
class Client
{

    /**
     * The API base URI.
     *
     * @var string
     */
    const BASE_URI = 'https://raw.githubusercontent.com/straube/dummy-sdk/master/assets/api/';

    /**
     * The HTTP client instance.
     *
     * @var Http
     */
    private $http;

    /**
     * Crate a new client instance.
     *
     * The API uses basic authentication. The username and password are passed 
     * to the `auth` option of Guzzle HTTP client. This way they don't have to 
     * be stored inside the class, neither be manually passed to all API 
     * requests.
     *
     * @param string $username The API user username.
     * @param string $password The API user password.
     */
    public function __construct($username, $password)
    {
        $this->http = new Http([
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'auth' => [
                $username,
                $password,
            ],
        ]);
    }

    /**
     * Get current API user.
     *
     * @return object The user.
     */
    public function getUser()
    {
        return $this->doRequest('GET', 'user.json');
    }

    /**
     * Send a request to the API.
     *
     * @param  string $method The HTTP method.
     * @param  string $endpoint The endpoint.
     * @param  array $params The params to send with the request.
     * @return array|object The response as JSON.
     */
    private function doRequest($method, $endpoint, array $params = null)
    {
        $options = [];
        if (!empty($params)) {
            $options['json'] = $params;
        }
        $response = $this->http->request($method, $endpoint, $options);
        return json_decode($response->getBody());
    }
}
