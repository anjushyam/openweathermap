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

    /**
     * Function to set and get weather data
     *
     * @param array $weatherData
     *
     * @return Weather
     *
     */
    public function weatherData(array $weatherData)
    {
        $this->setWeatherType($weatherData['weather'][0]['main']);
        $this->setTemperature(
            isset($weatherData['main']['temp']) ? $weatherData['main']['temp'] : ''
        );
        $this->setWind(
            [
                'speed' => $weatherData['wind']['speed'],
                'direction' => $weatherData['wind']['deg']
            ]
        );

        return $this;
    }
}