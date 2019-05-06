<?php

namespace AppBundle\Entity;

class Weather
{
    /**
     * @var string $weatherType
     */
    private $weatherType;

    /**
     * @var float $temperature
     */
    private $temperature;

    /**
     * @var array $wind
     */
    private $wind;

    /**
     * @param string $weatherType
     */
    public function setWeatherType(string $weatherType)
    {
        $this->weatherType = $weatherType;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature(float $temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @param array $wind
     */
    public function setWind(array $wind)
    {
        $this->wind = $wind;
    }
}