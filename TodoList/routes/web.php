<?php
use Illuminate\Http\Request;
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

$router->group(['prefix' => 'tarefas'], function () use ($router) {
    $router->get('/{param}','TarefaController@getTarefaById');
    $router->post('/', 'TarefaController@store');
    $router->put('/marca/{id}', 'TarefaController@finishTask');
    $router->put('/{idTarefa}/{idLista}','Tarefacontroller@moveTarefa');
    $router->delete('/{id}','TarefaController@destroy');   
});

$router->group(['prefix' => 'listas'], function () use ($router) {
    $router->get('/','ListaController@index');
    $router->post('/','ListaController@store');
    $router->put('/','ListaController@update');
    $router->delete('/{id}','ListaController@destroy');
});