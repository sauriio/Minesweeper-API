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
    return 'MineSweeper Api';
});

$router->group(['prefix' => 'game'], function () use ($router) {
    $router->get('/', ['uses' => 'GameController@getUserGames']);
    $router->post('/new', ['uses' => 'GameController@newGame']);
    $router->post('/{gameId:[0-9]+}/status', ['uses' => 'GameController@getGameStatus']);
    $router->get('/{gameId:[0-9]+}/pause', ['uses' => 'GameController@pauseResumeGame']);
    $router->post('/{gameId:[0-9]+}', ['uses' => 'GameController@makeMove']);
});
