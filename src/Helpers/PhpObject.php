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
        $array = self::toAssociativeArray($object);
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
        $dictionary = self::toAssociativeArray($object);
        $bool = PhpAssociativeArray::startsWith($dictionary, $needles);
        return $bool;
    }

    static public function endsWith(object $object, array $needles): bool
    {
        $dictionary = self::toAssociativeArray($object);
        $bool = PhpAssociativeArray::endsWith($dictionary, $needles);
        return $bool;
    }

    static public function reversed(object $object, bool $preserveMembers): object
    {
        $dictionary = self::toAssociativeArray($object);
        $dictionary = PhpAssociativeArray::reversed($dictionary, $preserveMembers);
        $object = PhpAssociativeArray::toObject($dictionary);
        return $object;
    }

    static public function toSortedObject(
        object $object,
        bool   $asc,
        bool   $caseSensitive,
        bool   $useKeys = false
    ): object
    {
        $dictionary = self::toAssociativeArray($object);
        $dictionary = PhpAssociativeArray::toSortedAssociativeArray($dictionary, $asc, $caseSensitive, $useKeys);
        $object = PhpAssociativeArray::toObject($dictionary);
        return $object;
    }

    static public function afterRemovingMembers(object $object, array $members): object
    {
        foreach ($members as $member) {
            if (method_exists($object, $member) or property_exists($object, $member)) {
                unset($object->{$member});
            }
        }
        return $object;
    }

    static public function afterSettingValue(object $object, $value, $member, bool $overwrite = true): object
    {
        $dictionary = self::toAssociativeArray($object);
        $dictionary = PhpAssociativeArray::afterSettingValue($dictionary, $value, $member, $overwrite);
        $object = PhpAssociativeArray::toObject($dictionary);
        return $object;
    }

    static public function toMembersAndValuesAssociativeArray(object $object): object
    {
        $dictionary = self::toAssociativeArray($object);
        $dictionary = PhpAssociativeArray::toMembersAndValuesAssociativeArray($dictionary);
        $object = PhpAssociativeArray::toObject($dictionary);
        return $object;
    }

    static public function hasMember(\stdClass $object, string $member): bool
    {
        return property_exists($object, $member);
    }
}
