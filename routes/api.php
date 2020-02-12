<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('', '/get')
        ->methods(['GET'])
        ->controller('HomeController@index');

    $routes->add('login', '/login')
        ->methods(['POST'])
        ->controller('Auth\LoginController@login');

    $routes->add('register', '/register')
        ->methods(['POST'])
        ->controller('Auth\RegisterController@register');

    $routes->add('subscribe', '/subscribe')
        ->methods(['POST'])
        ->controller('SubscriberController@subscribe');

    $routes->add('unsubscribe', '/unsubscribe')
        ->methods(['DELETE'])
        ->controller('SubscriberController@unsubscribe');
};
