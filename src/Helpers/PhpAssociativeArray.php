<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpObject
};

class PhpAssociativeArray
{
    static public function toIndexedArray(array $array = []): array
    {
        return array_values($array);
    }

    static public function toBool(array $array = []): bool
    {
        return PhpTypeJuggle::arrayToInt() > 0;
    }

    static public function toInt(array $array = []): int
    {
        return PhpTypeJuggle::arrayToInt($array);
    }

    static public function toJson(array $array = []): string
    {
        $object = self::toObject($array);
        $json = PhpObject::toJson($object);
        return $json;
    }

    static public function toObject(array $array = []): object
    {
        $object = (object) $array;
        return $object;
    }

    static public function toString(array $array = []): string
    {
        $string = PhpTypeJuggle::arrayToString($array);
        return str_replace("Array(", "Dictionary(", $string);
    }
}
