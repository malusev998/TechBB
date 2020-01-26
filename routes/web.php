<?php

use App\Controllers\HomeController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes ) {
    $routes->add('index', '/')
        ->controller([HomeController::class, 'index'])
        ->methods(['GET']);

    $routes->add('home', '/home')
        ->controller('HomeController@home')
        ->methods(['GET']);

    $routes->add('single-post', '/blog/{id}')
        ->controller('HomeController@singlePost')
        ->methods(['GET']);

};
