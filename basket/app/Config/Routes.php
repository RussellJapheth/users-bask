<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('/users', 'Users::create');
$routes->get('/', 'Users::index');
