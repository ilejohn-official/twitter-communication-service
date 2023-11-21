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

$router->get('/', 'WelcomeController@index');

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->group(['middleware' => 'user-auth'], function () use ($router) {
        $router->post('/chatbot/subscribe', 'UserController@subscribeToChatBot');
        $router->post('/chat/subscribe', 'UserController@subscribeToChat');

        $router->post('/messages/send', 'MessageController@send');
    });

    $router->post('/webhook/messenger', 'WebhookController@handleResponse');
});
