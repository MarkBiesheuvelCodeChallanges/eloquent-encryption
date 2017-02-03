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

$app->get('', [
    'as'   => 'default',
    'uses' => 'Controller@index',
]);

$app->get('products', [
    'as'   => 'products',
    'uses' => 'ProductController@index',
]);

$app->post('products', [
    'as'   => 'products.create',
    'uses' => 'ProductController@create',
]);

$app->get('products/{id}', [
    'as'   => 'products.read',
    'uses' => 'ProductController@read',
]);

$app->put('products/{id}', [
    'as'   => 'products.update',
    'uses' => 'ProductController@update',
]);

$app->patch('products/{id}', [
    'as'   => 'products.patch',
    'uses' => 'ProductController@update',
]);

$app->delete('products/{id}', [
    'as'   => 'products.delete',
    'uses' => 'ProductController@delete',
]);
