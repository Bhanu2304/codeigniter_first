<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
#$routes->get('/file_upload', 'FileUpload::index');
// $routes->post('/file_upload', 'FileUpload::index');
$routes->match(['get', 'post'], '/file_upload', 'FileUpload::index');
