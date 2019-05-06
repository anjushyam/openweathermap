<?php

namespace AppBundle\Transformer;

use AppBundle\Entity\Weather;

class WeatherTransformer
{
    /**
     * @var Weather $weather
     */
    private $weather;


    /**
     * WeatherDto constructor.
     */
    public function __construct()
    {
        $this->weather = new Weather();
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
        $this->weather->setWeatherType($weatherData['weather'][0]['main']);
        $this->weather->setTemperature(
            isset($weatherData['main']['temp']) ? $weatherData['main']['temp'] : ''
        );
        $this->weather->setWind(
            [
                'speed' => $weatherData['wind']['speed'],
                'direction' => $weatherData['wind']['deg']
            ]
        );

        return $this->weather;
    }
}