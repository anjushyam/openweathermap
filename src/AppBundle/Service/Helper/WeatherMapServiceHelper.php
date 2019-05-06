<?php

namespace AppBundle\Service\Helper;

class WeatherMapServiceHelper
{

    /**
     * Generate URL for openweathermap API endpoint to get current weather information
     *
     * @param string $weatherMapApiUrl
     * @param string $weatherMapAppId
     * @param string $city
     *
     * @return string
     *
     */
    public function generateWeatherMapURL(string $weatherMapApiUrl, string $weatherMapAppId, string $city)
    {
        return $weatherMapApiUrl . '?q=' . $city . '&appid=' . $weatherMapAppId;
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