<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpIndexedArray,
    PhpObject
};

class PhpAssociativeArray
{
    static public function endsWith(array $dictionary, array $needles): bool
    {
        $dictionary = self::reversed($dictionary, true);

        $needles = PhpIndexedArray::toValueMemberAssociativeArray($needles);
        $needles = self::reversed($needles, true);

        // Convert to array of value-member pairs
        $passing = [];
        foreach ($needles as $member => $value) {
            $passing[] = $value;
            $passing[] = $member;
        }
        $bool = self::startsWith($dictionary, $passing);
        return $bool;
    }

    static public function startsWith(array $dictionary, array $needles): bool
    {
        $needles = PhpIndexedArray::toValueMemberAssociativeArray($needles);
        $needleCount = count($needles);

        $dictionary = array_slice($dictionary, 0, $needleCount, true);
        return $needles === $dictionary;
    }

    // TODO: PHP 8.0 int|string = $member
    static public function afterSettingValue(
        array $array,
        $value,
        $member,
        bool $overwrite
    ): array
    {
        if ($member === null) {
            trigger_error("Null is not a valid member on array.");
        }

        if (isset($array[$member]) and $overwrite) {
            $set = [$member => $value];
            $array = array_replace($array, $set);

        } elseif ($overwrite) {
            $set = [$member => $value];
            $array = array_replace($array, $set);

        } else {
            $array[$member] = $value;

        }
        return $array;
    }

    static public function toMembersAndValuesAssociativeArray(array $dictionary): array
    {
        $left = array_keys($dictionary);
        $right = PhpAssociativeArray::toIndexedArray($dictionary);
        $dictionary = ["members" => $left, "values" => $right];
        return $dictionary;
    }

    static public function hasMember(array $array, string $member): bool
    {
        return array_key_exists($member, $array);
    }
}
