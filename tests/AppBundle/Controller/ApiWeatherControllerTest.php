<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ApiWeatherControllerTest
 *
 * @package Tests\AppBundle\Controller
 */
class ApiWeatherControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client $client
     */
    protected $client;

    /**
     *
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }
    
    /**
     *
     */
    public function testIndex()
    {
        $city = "London";
        $crawler = $this->doRequest($city);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $this->assertArrayHasKey('weather_type', $this->getContent());
        
    }
    
    /**
     * @param string $city
     *
     * @return string
     */
    public function doRequest(string $city)
    {
        return $this->client->request('GET', '/weather/current/' . $city . '/city');
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return json_decode($this->client->getResponse()->getContent(), true);
    }  
}