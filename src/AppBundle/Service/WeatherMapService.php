<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\Helper\CurlServiceHelper;
use AppBundle\Service\Helper\WeatherMapServiceHelper;
use AppBundle\Transformer\WeatherTransformer;

class WeatherMapService
{
    /**
     * @var $weatherMapApiUrl
     */
    private $weatherMapApiUrl;

    /**
     * @var $weatherMapAppId
     */
    private $weatherMapAppId;

    /**
     * @var CurlServiceHelper $curlServiceHelper
     */
    private $curlServiceHelper;

    /**
     * @var WeatherMapServiceHelper $weatherMapServiceHelper
     */
    private $weatherMapServiceHelper;

    /**
     * @var WeatherTransformer $weatherTransformer
     */
    private $weatherTransformer;

    /**
     * WeatherMapService constructor.
     *
     * @param $weatherMapApiUrl
     * @param $weatherMapAppId
     */
    public function __construct($weatherMapApiUrl, $weatherMapAppId)
    {
        $this->weatherMapApiUrl = $weatherMapApiUrl;
        $this->weatherMapAppId = $weatherMapAppId;
        $this->curlServiceHelper = new CurlServiceHelper();
        $this->weatherMapServiceHelper = new WeatherMapServiceHelper();
        $this->weatherTransformer = new WeatherTransformer();
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
            $this->weatherMapServiceHelper->generateWeatherMapURL(
                $this->weatherMapApiUrl,
                $this->weatherMapAppId,
                $city
            )
        );

        if ($response) {
            $weatherData = json_decode($response, true);

            if (isset($weatherData['cod']) && $weatherData['cod'] == Response::HTTP_OK) {
                $weatherData['wind']['deg'] = (isset($weatherData['wind']['deg'])) ?
                    $this->weatherMapServiceHelper->windDegreeToName($weatherData['wind']['deg']) : '';

                return $this->weatherTransformer->weatherData($weatherData);
            }
        }

        return false;
    }
}
