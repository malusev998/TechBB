<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('', '/get')
        ->methods(['GET'])
        ->controller('HomeController@index');

    // Auth

    $routes->add('login', '/login')
        ->methods(['POST', 'OPTIONS'])
        ->controller('Auth\LoginController@login');

    $routes->add('register', '/register')
        ->methods(['POST', 'OPTIONS'])
        ->controller('Auth\RegisterController@register');

    $routes->add('profile', '/profile')
        ->methods(['GET'])
        ->controller('Auth\\UserController@profile');

    // Subscriptions

    $routes->add('subscribe', '/subscribe')
        ->methods(['POST', 'OPTIONS'])
        ->controller('SubscribeController@subscribe');

    $routes->add('unsubscribe', '/unsubscribe')
        ->methods(['DELETE', 'OPTIONS'])
        ->controller('SubscribeController@unsubscribe');

    // Subjects

    $routes->add('get_subjects', '/subjects')
        ->methods(['GET'])
        ->controller('SubjectController@get');
    $routes->add('update_subjects', '/subjects/{id}')
        ->methods(['PATCH', 'OPTIONS'])
        ->controller('SubjectController@update');
    $routes->add('delete_subjects', '/subjects/{id}')
        ->methods(['DELETE', 'OPTIONS'])
        ->controller('SubjectController@delete');
    $routes->add('create_subject', '/subjects')
        ->methods(['POST', 'OPTIONS'])
        ->controller('SubjectController@create');

    // Contact

    $routes->add('get_messages', '/messages')
        ->methods(['POST', 'OPTIONS'])
        ->controller('ContactController@paginate');

    $routes->add('get_message', '/messages/{id}')
        ->methods(['GET'])
        ->controller('ContactController@get');

    $routes->add('contact', '/contact')
        ->methods(['POST', 'OPTIONS'])
        ->controller('ContactController@contact');

    $routes->add('delete_message', '/message/{id}')
        ->methods(['DELETE', 'OPTIONS'])
        ->controller('ContactController@delete');

    // Categories
    $routes->add('get_categories', '/categories')
        ->methods(['GET'])
        ->controller('Blog\\CategoryController@get');

    $routes->add('get_category', '/categories/{id}')
        ->methods(['GET'])
        ->controller('Blog\\CategoryController@getOne');

    $routes->add('get_popular_categories', '/popular/categories')
        ->methods(['GET'])
        ->controller('Blog\\CategoryController@getPopular');

    $routes->add('create_category', '/categories')
        ->methods(['POST', 'OPTIONS'])
        ->controller('Blog\\CategoryController@create');
    $routes->add('update_category', '/categories')
        ->methods(['PATCH', 'OPTIONS'])
        ->controller('Blog\\CategoryController@update');
    $routes->add('delete_category', '/categories/{id}')
        ->methods(['DELETE', 'OPTIONS'])
        ->controller('Blog\\CategoryController@delete');
    // Posts

    $routes->add('get_posts', '/posts')
        ->methods(['GET'])
        ->controller('Blog\\PostController@get');

    $routes->add('get_post', '/posts/{id}')
        ->methods(['GET'])
        ->controller('Blog\\PostController@getOne');

    $routes->add('get_popular_posts', '/popular/posts')
        ->methods(['GET'])
        ->controller('Blog\\PostController@getPopular');

    $routes->add('search_posts', '/posts/search')
        ->methods(['POST', 'OPTIONS'])
        ->controller('Blog\\PostController@search');

    $routes->add('add_post', '/posts')
        ->methods(['POST', 'OPTIONS'])
        ->controller('Blog\\PostController@create');

    $routes->add('update_post', '/posts/{id}')
        ->methods(['PATCH', 'OPTIONS'])
        ->controller('Blog\\PostController@update');

    $routes->add('delete_post', '/posts/{id}')
        ->methods(['DELETE', 'OPTIONS'])
        ->controller('Blog\\PostController@delete');
};
