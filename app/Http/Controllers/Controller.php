<?php

namespace App\Http\Controllers;

use App\Factories\PackingItemsFactory;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use NAWebCo\BoxPacker\Packer;

class Controller extends BaseController
{
    public function packing_attempt(Request $request)
    {
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
            $packer->addBox(PackingItemsFactory::buildContainer($boxData));
        }

        foreach( $request->items as $itemData ){
            $packer->addItem(PackingItemsFactory::buildSolid($itemData));
        }

        try {
            $result = $packer->pack();
        } catch( \Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }

        return [
            'success' => $result->success(),
            'packed' => $result->getPackedBoxes(true),
            'empty' => $result->getEmptyBoxes(true),
            'leftOverItems' => $result->getNotPackedItems()
        ];
    }
}
