<?php

namespace AppBundle\Service\Helper;

class CurlServiceHelper
{
    /**
     * Function to get data via curl by passing API endpoint URL
     *
     * @param string $apiUrl
     *
     * @return bool|string
     *
     */
    public function getData(string $apiUrl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $apiUrl,
        ]);

        $response = curl_exec($curl);

        if (curl_error($curl)) {
            $response = false;
        }

        curl_close($curl);

        return $response;
    }
}