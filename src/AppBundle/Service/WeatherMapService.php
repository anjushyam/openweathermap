<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Service\Helper\CurlServiceHelper;
use AppBundle\Service\Helper\WeatherMapServiceHelper;
use AppBundle\Transformer\WeatherTransformer;

class WeatherMapService
{
    /**
     * @var ContainerInterface $container
     */
    private $container;

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
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
                $this->container->getParameter('weathermap.api_url'),
                $this->container->getParameter('weathermap.app_id'),
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
