<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\OpenWeatherMap;

use GuzzleHttp\Client as GuzzleClient;
use stdClass;

class Client
{
    /**
     * @var string
     */
    protected $apiUrl = 'http://api.openweathermap.org/data/2.5/';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $units = 'metric';

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * Class constructor.
     *
     * @param $apiKey
     * @param null $apiUrl
     * @param null $units
     */
    public function __construct($apiKey, $apiUrl = null, $units = null)
    {
        $this->apiKey = $apiKey;

        if ($apiUrl) {
            $this->apiUrl = $apiUrl;
        }

        if ($units) {
            $this->units = $units;
        }

        $this->guzzleClient = new GuzzleClient();
    }

    /**
     * Performs a query to the OpenWeatherMap API.
     *
     * @param $name
     * @param array $parameters
     *
     * @return stdClass
     */
    public function query($name, $parameters = array())
    {
        // Pass the API key
        if (!isset($parameters['APPID'])) {
            $parameters['APPID'] = $this->apiKey;
        }

        // Pass the desired units
        if (!isset($parameters['units'])) {
            $parameters['units'] = $this->units;
        }

        // Part 2 : base url
        $baseUrl = $this->apiUrl.$name;

        // The call has to be made against the base url + query string
        $requestQueryParts = array();
        foreach ($parameters as $key => $value) {
            $requestQueryParts[] = $key.'='.rawurlencode($value);
        }
        $baseUrl .= '?'.implode('&', $requestQueryParts);

        $response = $this->guzzleClient->get($baseUrl);
        $response = json_decode($response->getBody()->getContents());

        return $response;
    }

    /**
     * Returns the current weather for a city.
     *
     * @param $city
     * @param array $parameters
     *
     * @return stdClass
     */
    public function getWeather($city, $parameters = array())
    {
        return $this->doGenericQuery('weather', $city, $parameters);
    }

    /**
     * Returns the forecast for a city.
     *
     * @param $city
     * @param $days
     * @param array $parameters
     *
     * @return stdClass
     */
    public function getForecast($city, $days = null, $parameters = array())
    {
        if ($days) {
            if (!empty($parameters)) {
                $parameters['cnt'] = $days;
            } else {
                $parameters = array('cnt' => $days);
            }
        }

        return $this->doGenericQuery('forecast/daily', $city, $parameters);
    }

    /**
     * @param $query
     * @param $city
     * @param array $parameters
     *
     * @return stdClass
     */
    private function doGenericQuery($query, $city, $parameters = array())
    {
        if (is_numeric($city)) {
            $parameters['id'] = $city;
        } else {
            $parameters['q'] = $city;
        }

        $response = $this->query($query, $parameters);

        return $response;
    }
}
