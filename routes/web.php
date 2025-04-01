<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });
    $router->get('countries', 'CountryController@getAllCountries');
});
