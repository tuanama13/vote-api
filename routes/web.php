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

// CRUD CALON KETUA
$router->get("calon-ketua", "CalonKetuaController@index");
$router->get("calon-ketua/{id}", "CalonKetuaController@detail");
$router->post("calon-ketua/insert", "CalonKetuaController@tambah");
$router->patch("calon-ketua/update", "CalonKetuaController@edit");
$router->delete("calon-ketua/delete/{id}", "CalonKetuaController@hapus");

// CRUD HASIL
$router->get("hasil", "HasilController@index");
$router->get("hasil/{id}", "HasilController@detail");
$router->post("hasil/insert", "HasilController@tambah");
$router->patch("hasil/update", "HasilController@edit");
$router->patch("hasil/vote", "HasilController@vote");
$router->delete("hasil/delete/{id}", "HasilController@hapus");
