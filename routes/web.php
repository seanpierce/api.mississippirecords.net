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

// Item Routes
$router->get('item', 'ItemController@getAll');
$router->get('item/{id}', 'ItemController@getById');
$router->post('item', 'ItemController@create');
$router->put('item', 'ItemController@update');
$router->delete('item/{id}', 'ItemController@delete');

// featured Items Routes
$router->get('item/featured', 'FeaturedItemController@getAll');
$router->post('item/featured', 'FeaturedItemController@create');
$router->delete('item/featured/{id}', 'FeaturedItemController@delete');