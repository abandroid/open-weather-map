Endroid OpenWeatherMap
======================

*By [endroid](http://endroid.nl/)*

[![Build Status](https://secure.travis-ci.org/endroid/OpenWeatherMap.png)](http://travis-ci.org/endroid/OpenWeatherMap)

OpenWeatherMap helps making requests to the OpenWeatherMap API, without having to bother too much about passing your API
key and building requests. The only thing you need is the API key (APPID) which you can find after [registration on the
website](http://openweathermap.org/login).

```php
<?php

$openWeatherMap = new Endroid\OpenWeatherMap\OpenWeatherMap($apiKey);

// Retrieve the current weather for Breda
$weather = $openWeatherMap->getWeather('Breda,nl');

// Or retrieve the weather using the generic query method
$response = $openWeatherMap->query('weather', array('q' => 'Breda,nl'));
$weather = json_decode($response->getContent());

```

## Symfony

You can use [`EndroidOpenWeatherMapBundle`](https://github.com/endroid/EndroidOpenWeatherMapBundle) to enable this
service in your Symfony application or to expose the OpenWeatherMap API through your own domain.

## License

This bundle is under the MIT license. For the full copyright and license information, please view the LICENSE file that
was distributed with this source code.
