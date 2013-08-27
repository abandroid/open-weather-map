<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\OpenWeatherMap;

use Buzz\Browser;
use Buzz\Client\Curl;

class OpenWeatherMap
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
     * Class constructor
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

        $this->browser = new Browser(new Curl());
    }

    /**
     * Performs a query to the OpenWeatherMap API.
     *
     * @param $name
     * @param array $parameters
     * @return \Buzz\Message\Response
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

        // Perform cURL request
        $response = $this->browser->get($baseUrl);

        return $response;
    }

    /**
     * Returns the current weather for a city
     *
     * @param $city
     * @param array $parameters
     * @return mixed
     */
    public function getWeather($city, $parameters = array())
    {
        if (is_numeric($city)) {
            $parameters['id'] = $city;
        } else {
            $parameters['q'] = $city;
        }

        $response = $this->query('weather', $parameters);

        return json_decode($response->getContent());
    }
}
