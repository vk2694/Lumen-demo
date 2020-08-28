<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// POST - Insert customer information
$router->post('/api/v0/customer', 'ExampleController@insertCustomer');
// POST - Bulk customer upload
$router->post('/api/v0/allcustomer', 'ExampleController@bulkCustomerUpload');
// PUT - Update the Customer information
$router->put('/api/v0/customer', 'ExampleController@updateCustomer');
// GET - Get customer information
$router->get('/api/v0/customer', 'ExampleController@getCustomer');
// DELETE - Delete the Customer information
$router->delete('/api/v0/customer', 'ExampleController@deleteCustomer');
