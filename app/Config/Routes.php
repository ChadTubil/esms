<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// LOGIN
$routes->add('/', 'LoginController::index');

$routes->set404Override(function() {
    echo view('errors/custom_error');
});