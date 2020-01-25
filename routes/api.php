<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes ) {
    $routes->add('', '/get')
        ->methods(['GET'])
        ->controller('HomeController@index');

};
