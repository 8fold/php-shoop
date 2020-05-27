<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpAssociativeArray,
    PhpObject
};

class PhpJson
{
    static public function toIndexedArray(string $json): array
    {
        self::isJson($json);
        $object = self::toObject($json);
        $array = PhpObject::toIndexedArray($object);
        return $array;
    }

    static public function toBool(string $json): bool
    {
        self::isJson($json);
        $object = self::toObject($json);
        $bool = PhpObject::toBool($object);
        return $bool;
    }

    static public function toAssociativeArray(string $json): array
    {
        self::isJson($json);
        $object = self::toObject($json);
        $array = PhpObject::toAssociativeArray($object);
        return $array;
    }

    static public function toInt(string $json): int
    {
        self::isJson($json);
        $object = self::toObject($json);
        $int = PhpObject::toInt($object);
        return $int;
    }

    static public function toObject(string $json): object
    {
        $object = json_decode($json);
        return $object;
    }

    static public function isJson(string $json): void
    {
        if (Type::isNotJson($json)) {
            trigger_error("The given string does not appear to be valid JSON.", E_USER_ERROR);
        }
    }
}
