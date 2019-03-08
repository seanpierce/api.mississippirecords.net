<?php

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

// Items Routes
$router->get('items', 'ItemController@getAll');
$router->get('items/{id}', 'ItemController@getById');
$router->post('items', 'ItemController@create');
$router->put('items', 'ItemController@update');
$router->delete('items/{id}', 'ItemController@delete');

// Featured Items Routes
$router->get('items/featured', 'FeaturedItemController@getAll');
$router->post('items/featured', 'FeaturedItemController@create');
$router->delete('items/featured/{id}', 'FeaturedItemController@delete');


// Orders Routes
$router->get('orders', 'OrderController@get_orders');
$router->post('orders/confirm', 'OrderController@confirm_order_details');
$router->post('orders/getstripedetails', 'OrderController@get_stripe_details');
$router->post('orders/markshipped', 'OrderController@mark_shipped');
$router->post('orders/payment', 'OrderController@make_payment');

// Users Routes
$router->post('login', 'UserController@login');
$router->post('users', 'UserController@get_user');

// Email Routes
$router->post('email/test', 'EmailController@send');