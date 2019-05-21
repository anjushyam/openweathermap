<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\GuzzleRequestHandler;
use AppBundle\Service\Helper\WeatherMapServiceHelper;
use AppBundle\Transformer\WeatherTransformer;

class WeatherMapService
{
    /**
     * @var WeatherMapServiceHelper $weatherMapServiceHelper
     */
    private $weatherMapServiceHelper;

    /**
     * @var WeatherTransformer $weatherTransformer
     */
    private $weatherTransformer;

    /**
     * @var GuzzleRequestHandler $guzzleRequestHandler
     */
    private $guzzleRequestHandler;

    /**
     * @var $weatherApiUrl
     */
    private $weatherApiUrl;

    /**
     * @var $weatherMapAppId
     */
    private $weatherMapAppId;

    /**
     * WeatherMapService constructor.
     *
     * @param WeatherMapServiceHelper $weatherMapServiceHelper
     * @param WeatherTransformer $weatherTransformer
     * @param string $weatherMapApiUrl
     * @param string $weatherMapAppId
     */
    public function __construct(WeatherMapServiceHelper $weatherMapServiceHelper, WeatherTransformer $weatherTransformer, GuzzleRequestHandler $guzzleRequestHandler, $weatherMapApiUrl, $weatherMapAppId)
    {
        $this->weatherMapServiceHelper = $weatherMapServiceHelper;
        $this->weatherTransformer = $weatherTransformer;
        $this->guzzleRequestHandler = $guzzleRequestHandler;
        $this->weatherApiUrl = $weatherApiUrl;
        $this->weatherMapAppId = $weatherMapAppId;
    }

    /**
     * Get current weather by city
     *
     * @param string $city
     *
     * @return bool|object
     *
     */
    public function currentWeatherByCity(string $city)
    {
        $response = $this->guzzleRequestHandler->get(
            $this->weatherApiUrl,
            [
                'q' => $city,
                'appid' => $this->weatherMapAppId 
            ]
        );

        if ($response) {
            $weatherData = json_decode($response, true);

            if (isset($weatherData['cod']) && $weatherData['cod'] == Response::HTTP_OK) {
                $weatherData['wind']['deg'] = (isset($weatherData['wind']['deg'])) ?
                    $this->weatherMapServiceHelper->windDegreeToNameConverter($weatherData['wind']['deg']) : '';

                return $this->weatherTransformer->transform($weatherData);
            }
        }

        return false;
    }
}
