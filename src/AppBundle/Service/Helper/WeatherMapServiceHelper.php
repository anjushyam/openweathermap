<?php

namespace AppBundle\Service\Helper;

class WeatherMapServiceHelper
{
    /**
     * @var $container
     */
    private $container;

    /**
     * WeatherMapServiceHelper constructor.
     */
    public function __construct()
    {
        global $kernel;

        $this->container = $kernel->getContainer();
    }

    /**
     * Generate URL for openweathermap API endpoint to get current weather information
     *
     * @param string $city
     *
     * @return string
     *
     */
    public function generateWeatherMapURL(string $city)
    {
        return $this->container->getParameter('weather_api_url') . '?q=' . $city .
            '&appid=' . $this->container->getParameter('app_id');
    }

    /**
     * Get wind direction name by degree
     *
     * @param float $windDirection
     *
     * @return string
     *
     */
    public function windDegreeToName(float $windDirection)
    {
        $compass = ['North', 'NNE', 'NorthEast', 'ENE', 'East', 'ESE', 'SouthEast', 'SSE', 'South', 'SSW', 'SouthWest', 'WSW', 'West', 'WNW', 'NorthWest', 'NNW'];

        return $compass[round(($windDirection - 11.25) / 22.5)];
    }
}