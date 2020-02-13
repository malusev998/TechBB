<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('', '/get')
        ->methods(['GET'])
        ->controller('HomeController@index');

    // Auth

    $routes->add('login', '/login')
        ->methods(['POST'])
        ->controller('Auth\LoginController@login');

    $routes->add('register', '/register')
        ->methods(['POST'])
        ->controller('Auth\RegisterController@register');

    // Subscriptions

    $routes->add('subscribe', '/subscribe')
        ->methods(['POST'])
        ->controller('SubscribeController@subscribe');

    $routes->add('unsubscribe', '/unsubscribe')
        ->methods(['DELETE'])
        ->controller('SubscribeController@unsubscribe');

    // Subjects

    $routes->add('get_subjects', '/subjects')
        ->methods(['GET'])
        ->controller('SubjectController@get');
    $routes->add('update_subjects', '/subjects/{id}')
        ->methods(['PATCH'])
        ->controller('SubjectController@update');
    $routes->add('delete_subjects', '/subjects/{id}')
        ->methods(['DELETE'])
        ->controller('SubjectController@delete');
    $routes->add('create_subject', '/subjects')
        ->methods(['POST'])
        ->controller('SubjectController@create');

    // Contact

    $routes->add('get_messages', '/messages')
        ->methods(['POST'])
        ->controller('ContactController@paginate');

    $routes->add('get_message', '/messages/{id}')
        ->methods(['GET'])
        ->controller('ContactController@get');

    $routes->add('contact', '/contact')
        ->methods(['POST'])
        ->controller('ContactController@contact');

    $routes->add('delete_message', '/message/{id}')
        ->methods(['DELETE'])
        ->controller('ContactController@delete');

    // Categories
    $routes->add('get_categories', '/categories')
        ->methods(['GET'])
        ->controller('CategoryController@get');
    $routes->add('get_category', '/categories/{id}')
        ->methods(['GET'])
        ->controller('CategoryController@getOne');
    $routes->add('get_popular_categories', '/categories')
        ->methods(['GET'])
        ->controller('CategoryController@getPopular');
    $routes->add('create_category', '/categories')
        ->methods(['POST'])
        ->controller('CategoryController@create');
    $routes->add('update_category', '/categories')
        ->methods(['PATCH'])
        ->controller('CategoryController@update');
    $routes->add('delete_category', '/categories/{id}')
        ->methods(['DELETE'])
        ->controller('CategoryController@delete');
    // Posts
};
