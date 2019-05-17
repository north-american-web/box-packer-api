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
    return 'Documentation: <a href="https://github.com/north-american-web/box-packer-api">https://github.com/north-american-web/box-packer-api</a>';
});

$router->post('/v1/packing_attempt', function (Request $request) {
    $this->validate($request, [
        'boxes' => 'required|array',
        'boxes.*' => 'required|array',
        'boxes.*.width' => 'required|numeric|gt:0',
        'boxes.*.length' => 'required|numeric|gt:0',
        'boxes.*.height' => 'required|numeric|gt:0',
        'boxes.*.description' => 'nullable|between:1,128',
        'items' => 'required|array',
        'items.*' => 'required|array',
        'items.*.width' => 'required|numeric|gt:0',
        'items.*.length' => 'required|numeric|gt:0',
        'items.*.height' => 'required|numeric|gt:0',
        'items.*.description' => 'nullable|between:1,128',
    ]);

    $packer = new Packer();

    foreach( $request->boxes as $boxData ){
        $packer->addContainer(PackingItemsFactory::buildContainer($boxData));
    }

    foreach( $request->items as $itemData ){
        $packer->addItem(PackingItemsFactory::buildSolid($itemData));
    }

    try {
        $result = $packer->pack();
    } catch( \Exception $e){
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    return response()->json([
        'success' => $result->success(),
        'packed' => $result->getPackedContainers(),
        'empty' => $result->getEmptyContainers(),
        'leftOverItems' => $result->getNotPackedItems()
    ]);
});