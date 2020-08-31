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

$router->group(['middleware' => 'jwt.auth', 'prefix' => ''],
    function () use ($router)
    {
        $router->post('/logout', 'UserController@logout');

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

        $router->group(['prefix' => 'finance-transaction'], 
            function () use ($router)
            {
                $router->get('', 'FinanceTransactionController@list');
                $router->get('/{id}', 'FinanceTransactionController@detail');
                $router->post('', 'FinanceTransactionController@create');
                $router->patch('/{id}', 'FinanceTransactionController@update');
                $router->delete('/{id}', 'FinanceTransactionController@delete');
            }
        );
    }
);