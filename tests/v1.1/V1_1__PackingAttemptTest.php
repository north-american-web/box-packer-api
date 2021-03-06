<?php

namespace V1_1;

class PackingAttemptTest extends \TestCase
{
    /**
     * @return void
     */
    public function testValidPackingAttempt()
    {
        $this->json('GET', '/v1.1/packing_attempt', [
            'boxes' => [
                [
                    'width' => 3,
                    'length' => 2,
                    'height' => 1,
                    'description' => 'box',
                ]
            ],
            'items' => [
                [
                    'width' => 3,
                    'length' => 2,
                    'height' => 1,
                    'description' => 'item'
                ]
            ]
        ])->seeJsonStructure([
            'success',
            'packed' => [
                [
                    'width',
                    'length',
                    'height',
                    'description',
                    'contents' => [
                        ['width', 'length', 'height', 'description']
                    ]]
            ],
            'empty',
            'leftOverItems'
        ]);
    }

    /**
     * @return void
     */
    public function testInvalidPackingAttempt()
    {
        $this->json('GET', '/v1.1/packing_attempt', [
            'boxes' => [
                [
                    'width' => 3,
                    'length' => 2,
                    'height' => 1,
                    'description' => 'box',
                ]
            ],
            'items' => [
                [
                    'width' => 6,
                    'length' => 2,
                    'height' => 1,
                    'description' => 'item'
                ]
            ]
        ])->seeJson([
            'success' => false ]
        )->seeJsonStructure([
            'success',
            'packed',
            'empty',
            'leftOverItems' => [
                ['width', 'length', 'height', 'description']
            ]
        ]);
    }

    // @todo test exception response
}
