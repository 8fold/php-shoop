<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpIndexedArray,
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
        $int = PhpIndexedArray::toInt($array);
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

    // TODO: No tests failed - need tests
    static public function startsWith(object $object, array $needles): bool
    {
        $dictionary = (array) $object;
        $bool = PhpAssociativeArray::startsWith($dictionary, $needles);
        return $bool;
    }

    static public function endsWith(object $object, array $needles): bool
    {
        $dictionary = (array) $object;
        $bool = PhpAssociativeArray::endsWith($dictionary, $needles);
        return $bool;
    }

    static public function reversed(object $object, bool $preserveMembers): object
    {
        $dictionary = self::toAssociativeArray($object);
        $dictionary = PhpAssociativeArray::reversed($dictionary, $preserveMembers);
        $object = (object) $dictionary;
        return $object;
    }

    static public function toSortedObject(object $object, bool $asc, bool $caseSensitive): object
    {
        $dictionary = (array) $object;
        $dictionary = PhpAssociativeArray::toSortedAssociativeArray($dictionary, $asc, $caseSensitive);
        $object = (object) $dictionary;
        return $object;
    }
}
