<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class GuzzleRequestHandler
{
    /**
     * @var $client
     */
    private $client;

    /**
     * GuzzleRequestHandler constructor
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Function to get data from API by passing url and parameters using GET method
     *
     * @param string $apiUrl
     * @param array $queryParams
     *
     * @return bool|string
     */
    public function get(string $apiUrl, $queryParams = [])
    {
        $queryParams = !empty($queryParams) ? ['query' => $queryParams] : [];
        return $this->makeRequest('GET', $apiUrl, $queryParams);
    }

    /**
     * Function to get data from API by passing method, url and parameters
     *
     * @param string $method
     * @param string $apiUrl
     * @param array $parameters
     *
     * @return bool|string
     *
     */
    private function makeRequest(string $method, string $apiUrl, $parameters = [])
    {

       $response = $this->client->request($method, $apiUrl, $parameters);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            return $response->getBody()->getContents();
        }

        return false;
    }
}