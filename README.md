Endroid OpenWeatherMap
======================

*By [endroid](http://endroid.nl/)*

[![Build Status](https://secure.travis-ci.org/endroid/OpenWeatherMap.png)](http://travis-ci.org/endroid/OpenWeatherMap)
[![Latest Stable Version](https://poser.pugx.org/endroid/openweathermap/v/stable.png)](https://packagist.org/packages/endroid/openweathermap)
[![Total Downloads](https://poser.pugx.org/endroid/openweathermap/downloads.png)](https://packagist.org/packages/endroid/openweathermap)

OpenWeatherMap helps making requests to the OpenWeatherMap API, without having to bother too much about passing your API
key and building requests. The only thing you need is the API key (APPID) which you can find after [registration on the
website](http://openweathermap.org/login).

More info about custom parameters in the official API docs: http://bugs.openweathermap.org/projects/api/wiki/Api_2_5

```php
<?php

use Endroid\OpenWeatherMap\Client;

$client = new Client($apiKey);

// Retrieve the current weather for Breda
$weather = $client->getWeather('Breda,nl');

// Or retrieve the weather using the generic query method
$response = $client->query('weather', array('q' => 'Breda,nl'));
$weather = json_decode($response->getContent());

// You can also retrieve a N days forecast
$forecast = $client->getForecast('Breda,nl', 7);

```

## Symfony

You can use [`EndroidOpenWeatherMapBundle`](https://github.com/endroid/EndroidOpenWeatherMapBundle) to enable this
service in your Symfony application or to expose the OpenWeatherMap API through your own domain.

## Versioning

Semantic versioning ([semver](http://semver.org/)) is applied as much as possible.

## License

This bundle is under the MIT license. For the full copyright and license information, please view the LICENSE file that
was distributed with this source code.
