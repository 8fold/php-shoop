<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpTypeJuggle,
    PhpIndexedArray,
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
        return self::toInt($array);
    }

    static public function toInt(array $array = []): int
    {
        return count($array);
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
        $string = PhpIndexedArray::toString($array);
        return str_replace("Array(", "Dictionary(", $string);
    }

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

    static public function reversed(array $array, bool $preserveMembers): array
    {
        return ($preserveMembers)
            ? array_reverse($array, true)
            : array_reverse($array);
    }

    static public function toSortedAssociativeArray(
        array $dictionary,
        bool  $asc,
        bool  $caseSensitive,
        bool  $useKeys = false
    ): array
    {
        if ($asc) {
            if ($useKeys) {
                ksort($dictionary, SORT_NATURAL);

            } elseif ($caseSensitive) {
                asort($dictionary, SORT_NATURAL);

            } else {
                asort($dictionary, SORT_NATURAL | SORT_FLAG_CASE);

            }

        } else {
            if ($useKeys) {
                krsort($dictionary, SORT_NATURAL);

            } elseif ($caseSensitive) {
                arsort($dictionary, SORT_NATURAL);

            } else {
                arsort($dictionary, SORT_NATURAL | SORT_FLAG_CASE);

            }
        }
        return $dictionary;
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

    static public function afterDropping(array $array, int $length): array
    {
        if ($length >= 0) {
            // first
            array_splice($array, 0, $length);

        } else {
            // last
            array_splice($array, $length);

        }
        return $array;
    }

    static public function afterDroppingEmpties(array $array): array
    {
        return array_filter($array);
    }

    static public function hasMember(array $array, string $member): bool
    {
        return array_key_exists($member, $array);
    }
}
