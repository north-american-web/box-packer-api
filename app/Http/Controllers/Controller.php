<?php

namespace App\Http\Controllers;

use App\Factories\PackingItemsFactory;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use NAWebCo\BoxPacker\GenericPackable;
use NAWebCo\BoxPacker\Packer;

class Controller extends BaseController
{
    public function packing_attempt(Request $request)
    {
        $data = $this->validateRequest($request);

        $packer = new Packer();

        foreach( $data['boxes'] as $boxData ){
            $packer->addBox(PackingItemsFactory::buildContainer($boxData));
        }

        foreach( $data['items'] as $itemData ){
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

        $return = [
            'success' => $result->success(),
            'packed' => $this->normalizePackingResults($result->getPackedBoxes(true)),
            'empty' => $this->normalizePackingResults($result->getEmptyBoxes(true)),
            'leftOverItems' => $result->getNotPackedItems()
        ];
     //   var_dump($return); exit();
        return $return;
    }

    /**
     * Force the returned data to conform to a flatter structure, with solid dimensional attributes and "contents"
     * fields at the same level.
     *
     * @param $results
     * @return array
     */
    protected function normalizePackingResults( $results )
    {
        if( !$results ){
            return $results;
        }

        $normalized = [];
        foreach( $results as $result ){
            /** @var GenericPackable $box */
            $box = $result['box'];
            $data = $box->toArray();
            $data['contents'] = $result['contents'];
            $normalized[] = $data;
        }
        return $normalized;
    }

    protected function validateRequest(Request $request)
    {
        return $this->validate($request, [
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
    }
}
