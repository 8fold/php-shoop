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

    static public function toSortedAssociativeArray(array $dictionary, bool $asc, bool $caseSensitive): array
    {
        if ($asc) {
            if ($caseSensitive) {
                asort($dictionary, SORT_NATURAL);

            } else {
                asort($dictionary, SORT_NATURAL | SORT_FLAG_CASE);

            }

        } else {
            if ($caseSensitive) {
                arsort($dictionary, SORT_NATURAL);

            } else {
                arsort($dictionary, SORT_NATURAL | SORT_FLAG_CASE);

            }
        }
        return $dictionary;
    }
}
