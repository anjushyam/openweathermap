<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use AppBundle\Service\WeatherMapService;

class ApiWeatherController extends FOSRestController
{
    /**
     * To get current weather information by city
     *
     * @param $city
     * @param WeatherMapService $weatherMapService
     *
     * @return Response
     *
     * @Get("/weather/current/{city}/city", requirements={"city"="^[A-Za-z]+$"})
     *
     * @throw HttpException
     *
     * @ApiDoc(
     *  section="Weather API",
     *  description="Get current weather information",
     *  output="Json",
     *  statusCodes={
     *      200="Returned when successful",
     *      500="When openweathermap API fail to return response",
     *  }
     * )
     */
    public function getCurrentWeatherAction($city, WeatherMapService $weatherMapService)
    {
        $response = $weatherMapService->getCurrentWeather($city);

        if (!$response) {
            throw new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR, 'Weather Information is temporarily unavailable');
        }

        return $this->handleView($this->view($response, Response::HTTP_OK));
    }
}