<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('countries', 'CountryController@getAllCountries');
    $router->get('airlines', 'AirlineController@getAllAirlines');
    $router->get('airlines/{id}', 'AirlineController@getAirlineById');
    $router->post('airlines', 'AirlineController@createAirline');
    $router->put('airlines/{id}', 'AirlineController@updateAirline');
    $router->delete('airlines/{id}', 'AirlineController@deleteAirline');
    $router->get('airports', 'AirportController@getAllAirports');
    $router->get('airports/{id}', 'AirportController@getAirportById');
    $router->post('airports', 'AirportController@createAirport');
    $router->put('airports/{id}', 'AirportController@updateAirport');
    $router->delete('airports/{id}', 'AirportController@deleteAirport');
});
