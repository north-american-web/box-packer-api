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

use App\Factories\PackingItemsFactory;
use Illuminate\Http\Request;
use NAWebCo\BoxPacker\Packer;

$router->get('/', function () use ($router) {
    return '<!DOCTYPE html><p>Documentation: <a href="https://github.com/north-american-web/box-packer-api">https://github.com/north-american-web/box-packer-api</a></p>';
});

$router->post('/v1/packing_attempt', 'Controller@packing_attempt');