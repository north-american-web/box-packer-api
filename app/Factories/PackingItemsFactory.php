<?php

namespace App\Factories;

use NAWebCo\BoxPacker\Solid;
use NAWebCo\BoxPacker\Container;

class PackingItemsFactory
{

    /**
     * @param $data
     * @return Container
     */
    public static function buildContainer($data)
    {
        return self::buildSolidInterfaceObject($data, Container::class);
    }

    /**
     * @param $data
     * @return Solid
     */
    public static function buildSolid($data)
    {
        return self::buildSolidInterfaceObject($data, Solid::class);
    }

    /**
     * @param $data
     * @param $class
     * @return \NAWebCo\BoxPacker\SolidInterface
     */
    protected static function buildSolidInterfaceObject( $data, $class )
    {
        $width = isset($data['width']) ? (float) $data['width'] : 0.0;
        $length =  isset($data['length']) ? (float) $data['length'] : 0.0;
        $height = isset($data['height']) ? (float) $data['height'] : 0.0;
        $description = isset($data['description']) ? $data['description'] : null;

        return new $class($width, $length, $height, $description);
    }
}