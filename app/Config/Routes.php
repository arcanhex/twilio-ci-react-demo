<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  $routes->options('(:any)', function () {
//     return response()
//         ->setHeader('Access-Control-Allow-Origin', 'http://localhost:5173')
//         ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
//         ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
//         ->setStatusCode(200)
//         ->setBody('OK');
// });

// $routes->options('(:any)', function () {
//     log_message('debug', 'OPTIONS route hit');
//     return response()->setStatusCode(200)->setBody('OK');
// });

$routes->group('api', ['filter' => 'cors'], function ($routes) {
    $routes->get('list', 'Home::list');
    $routes->post('create', 'Home::create');

    $routes->options('create', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');

        return $response;
    });
});

$routes->group('password', ['filter' => 'cors'], function ($routes) {
    $routes->post('/', 'Password::index');

    $routes->options('/', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');

        return $response;
    });
});

$routes->get('password/create', 'Password::create');

// $routes->options('api/create', 'Home::create');

// Catch-all route for other URIs
// $routes->add('(:any)', 'Blocker::index');
// $routes->setDefaultController('Blocker');
// $routes->setDefaultMethod('index');
