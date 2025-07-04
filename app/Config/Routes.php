<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

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

// $routes->get('(:any)', 'Home::index');
