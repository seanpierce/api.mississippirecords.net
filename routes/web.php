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
$router->get('featured', 'FeaturedItemController@getAll');
$router->post('featured', 'FeaturedItemController@create');
$router->delete('featured/{id}', 'FeaturedItemController@delete');


// Orders Routes
$router->get('orders', 'OrderController@get_orders');
$router->post('orders/confirm', 'OrderController@confirm_order_details');
$router->post('orders/getstripedetails', 'OrderController@get_stripe_details');
$router->post('orders/markshipped', 'OrderController@mark_shipped');
$router->post('orders/payment', 'OrderController@make_payment');
$router->post('orders/international', 'OrderController@request_international_order');

// Users Routes
$router->post('users', 'UserController@get_user');
$router->get('b2bmembers', 'B2BMemberController@get_b2b_members');
$router->post('b2bmembers/delete', 'B2BMemberController@delete_b2b_member');
$router->get('b2bmembers/address', 'B2BMemberController@get_b2b_member_address');
$router->get('b2bmembers/requests', 'B2BMemberController@get_b2b_member_requests');
$router->post('b2bmembers/request', 'B2BMemberController@create_b2b_member_request');
$router->post('b2bmembers/approve', 'B2BMemberController@approve_b2b_member_request');
$router->post('b2bmembers/deny', 'B2BMemberController@deny_b2b_member_request');

// Auth Routes
$router->post('login', 'UserController@login');
$router->post('authorize/admin', 'AuthController@is_logged_in_admin');
$router->post('authorize/b2b', 'AuthController@is_logged_in_b2b');

// Posts Routes
$router->get('posts/{page_name}', 'PostController@get_page_posts');
$router->post('posts', 'PostController@create_post');
$router->put('posts', 'PostController@update_post');
$router->delete('posts', 'PostController@delete_post');

// Misc Routes
$router->post('upload', 'UploadController@upload_file');
$router->post('keys/stripe', 'KeysController@get_stripe_pk');