<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpAssociativeArray
};

class PhpObject
{
    static public function toIndexedArray(object $object): array
    {
        $array = (array) $object;
        $array = array_values($array);
        return $array;
    }

    static public function toBool(object $object): bool
    {
        $array = self::toAssociativeArray($object);
        $bool = PhpIndexedArray::toBool($array);
        return $bool;
    }

    static public function toAssociativeArray(object $object): array
    {
        $array = (array) $object;
        return $array;
    }

    static public function toInt(object $object): int
    {
        $array = self::toIndexedArray($object);
        $int = PhpTypeJuggle::arrayToInt($array);
        return $int;
    }

    static public function toJson(object $object): string
    {
        return json_encode($object);
    }

    static public function toString(object $object): string
    {
        $array = self::toAssociativeArray($object);
        $string = PhpAssociativeArray::toString($array);
        $string = str_replace("Dictionary(", "stdClass Object(", $string);
        return $string;
    }
}
