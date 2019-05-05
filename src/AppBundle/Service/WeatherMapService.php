<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\Helper\CurlServiceHelper;
use AppBundle\Service\Helper\WeatherMapServiceHelper;
use AppBundle\Entity\Weather;

class WeatherMapService
{
    /**
     * @var CurlServiceHelper $curlServiceHelper
     */
    private $curlServiceHelper;

    /**
     * @var WeatherMapServiceHelper $weatherMapServiceHelper
     */
    private $weatherMapServiceHelper;

    /**
     * @var Weather $weather
     */
    private $weather;

    /**
     * WeatherMapService constructor.
     */
    public function __construct()
    {
        $this->curlServiceHelper = new CurlServiceHelper();
        $this->weatherMapServiceHelper = new WeatherMapServiceHelper();
        $this->weather = new Weather();
    }

    /**
     * Get current weather by city
     *
     * @param string $city
     *
     * @return bool|object
     *
     */
    public function getCurrentWeather(string $city)
    {
        $response = $this->curlServiceHelper->getData(
            $this->weatherMapServiceHelper->generateWeatherMapURL($city)
        );

        if ($response) {
            $weatherData = json_decode($response, true);

            if (isset($weatherData['cod']) && $weatherData['cod'] == Response::HTTP_OK) {
                $weatherData['wind']['deg'] = (isset($weatherData['wind']['deg'])) ?
                    $this->weatherMapServiceHelper->windDegreeToName($weatherData['wind']['deg']) : '';

                return $this->weather->weatherData($weatherData);
            }
        }

        return false;
    }
}
