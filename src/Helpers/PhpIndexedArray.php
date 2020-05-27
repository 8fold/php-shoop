<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\PhpTypeJuggle;

class PhpIndexedArray
{
    static public function toBool(array $array = []): bool
    {
        return PhpTypeJuggle::arrayToInt($array) > 0;
    }

    static public function toAssociativeArray(array $array = []): array
    {
        $build = [];
        foreach ($array as $member => $value) {
            $member = "i". $member;
            $build[$member] = $value;
        }
        return $build;
    }

    static public function toInt(array $array = []): int
    {
        return PhpTypeJuggle::arrayToInt($array);
    }

    static public function toJson(array $array = []): string
    {
        $object = self::toObject($array);
        $json = json_encode($object);
        return $json;
    }

    static public function toObject(array $array = []): object
    {
        $associativeArray = self::toAssociativeArray($array);
        $object = (object) $associativeArray;
        return $object;
    }

    static public function toString(array $array = []): string
    {
        return PhpTypeJuggle::arrayToString($array);
    }
}
