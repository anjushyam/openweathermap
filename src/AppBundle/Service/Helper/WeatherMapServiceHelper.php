<?php

namespace AppBundle\Service\Helper;

class WeatherMapServiceHelper
{
    /**
     * Get wind direction name by degree
     *
     * @param float $windDirection
     *
     * @return string
     *
     */
    public function windDegreeToNameConverter(float $windDirection)
    {
        $compass = ['North', 'NNE', 'NorthEast', 'ENE', 'East', 'ESE', 'SouthEast', 'SSE', 'South', 'SSW', 'SouthWest', 'WSW', 'West', 'WNW', 'NorthWest', 'NNW'];

        return $compass[round(($windDirection - 11.25) / 22.5)];
    }
}