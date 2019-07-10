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

$router->get('/', function () {
    return '<!DOCTYPE html>
<title>Box Packer API - North American Web Company</title>
<p>Documentation: <a href="https://github.com/north-american-web/box-packer-api">https://github.com/north-american-web/box-packer-api</a></p>';
});

$router->post('/v1/packing_attempt', 'Controller@packing_attempt');

$router->get('/v1.1/packing_attempt', 'Controller@packing_attempt');