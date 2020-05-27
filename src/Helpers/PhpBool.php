<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpAssociativeArray
};

class PhpBool
{
    static public function toIndexedArray(bool $bool = true): array
    {
        return [$bool];
    }

    static public function toAssociativeArray(bool $bool = true): array
    {
        return ($bool === true)
            ? ["true" => true, "false" => false]
            : ["true" => false, "false" => true];
    }

    static public function toInt(bool $bool = true): int
    {
        $int = $bool
            ? 1
            : 0;
        return $int;
    }

    static public function toJson(bool $bool = true): string
    {
        $object = self::toObject($bool);
        $json = PhpObject::toJson($object);
        return $json;
    }

    static public function toObject(bool $bool = true): object
    {
        $dictionary = self::toAssociativeArray($bool);
        $object = PhpAssociativeArray::toObject($dictionary);
        return $object;
    }

    static public function toString(bool $bool = true): string
    {
        $bool = $bool ? "true" : "";
        return $bool;
    }
}
