<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpAssociativeArray,
    PhpObject
};

class PhpInt
{
    static public function toIndexedArray(int $int, int $start = 0): array
    {
        return ($start > $int)
            ? range($int, $start)
            : range($start, $int);
    }

    static public function toBool(int $int): bool
    {
        $bool = (bool) $int;
        return $bool;
    }

    static public function toAssociativeArray(int $int): array
    {
        $array = self::toIndexedArray($int);
        $array = PhpIndexedArray::toAssociativeArray($array);
        return $array;
    }

    static public function toJson(int $int): string
    {
        $object = self::toObject($int);
        $json = PhpObject::toJson($object);
        return $json;
    }

    static public function toObject(int $int): object
    {
        $array = self::toAssociativeArray($int);
        $object = PhpAssociativeArray::toObject($array);
        return $object;
    }

    static public function toString(int $int): string
    {
        $string = (string) $int;
        return $string;
    }

    static public function isOdd(int $int): bool
    {
        return $int&1;
    }

    static public function isEven(int $int): bool
    {
        return $int % 2 === 0;
    }
}
