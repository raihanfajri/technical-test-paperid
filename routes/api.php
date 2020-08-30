<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->post('/register', 'UserController@create');
$router->post('/login', 'UserController@authenticate');

$router->group(['prefix' => 'finance-account'], 
    function () use ($router)
    {
        $router->get('', 'FinanceAccountController@list');
        $router->get('/{id}', 'FinanceAccountController@detail');
        $router->post('', 'FinanceAccountController@create');
        $router->patch('/{id}', 'FinanceAccountController@update');
        $router->delete('/{id}', 'FinanceAccountController@delete');
    }
);