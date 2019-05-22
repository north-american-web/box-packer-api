<?php

namespace App\Factories;

use NAWebCo\BoxPacker\GenericPackable;
use NAWebCo\BoxPacker\Solid;
use NAWebCo\BoxPacker\Container;

class PackingItemsFactory
{

    /**
     * @param $data
     * @return GenericPackable
     */
    public static function buildContainer($data)
    {
        return self::buildGenericPackable($data);
    }

    /**
     * @param $data
     * @return GenericPackable
     */
    public static function buildSolid($data)
    {
        return self::buildGenericPackable($data);
    }

    /**
     * @param $data
     * @return GenericPackable
     */
    protected static function buildGenericPackable($data )
    {
        $width = isset($data['width']) ? (float) $data['width'] : 0.0;
        $length =  isset($data['length']) ? (float) $data['length'] : 0.0;
        $height = isset($data['height']) ? (float) $data['height'] : 0.0;
        $description = isset($data['description']) ? $data['description'] : null;

        return new GenericPackable($width, $length, $height, $description);
    }
}