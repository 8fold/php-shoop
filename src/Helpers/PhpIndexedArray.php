<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpInt
};

class PhpIndexedArray
{
    static public function toBool(array $array = []): bool
    {
        return self::toInt($array) > 0;
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
        return count($array);
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
        $printed = print_r($array, true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        $fixSpacingWhenEmpty = preg_replace('/\s+\(/', "(", $commas, 1);
        return trim($fixSpacingWhenEmpty);
    }

    static public function reversed(array $array, bool $preserveMembers): array
    {
        return ($preserveMembers)
            ? array_reverse($array, true)
            : array_reverse($array);
    }

    static public function toValueMemberAssociativeArray(array $array): array
    {
        if (PhpInt::isOdd(self::toInt($array))) {
            $className = static::class;
            $argCount = self::toInt($array);
            trigger_error(
                "{$className}::indexedArrayToValueMemberArray() expects two (or more) arguments. {$argCount} given."
            );
        }
        $count = 0;
        $members = [];
        $values = [];
        foreach ($array as $value) {
            if ($count === 0 or $count % 2 === 0) {
                $values[] = $value;

            } else {
                $members[] = $value;

            }
            $count++;
        }
        $dictionary = array_combine($members, $values);
        return $dictionary;
    }

    static public function startsWith(array $array, array $needles): bool
    {
        foreach ($needles as $member => $value) {
            if ($array[$member] !== $value) {
                return false;
            }
        }
        return true;
    }

    static public function endsWith(array $array, array $needles): bool
    {
        $array = self::reversed($array, false);
        $needles = self::reversed($needles, false);
        $bool = self::startsWith($array, $needles);
        return $bool;
    }

    static public function toSortedIndexedArray(
        array $array,
        bool  $asc,
        bool  $caseSensitive,
        bool  $useKeys = false
    ): array
    {
        if ($asc) {
            if ($useKeys) {
                ksort($array, SORT_NATURAL);

            } elseif ($caseSensitive) {
                sort($array, SORT_NATURAL);

            } else {
                sort($array, SORT_NATURAL | SORT_FLAG_CASE);

            }

        } else {
            if ($useKeys) {
                krsort($array);

            } elseif ($caseSensitive) {
                rsort($array, SORT_NATURAL);

            } else {
                rsort($array, SORT_NATURAL | SORT_FLAG_CASE);

            }
        }
        return $array;
    }

    static public function afterSettingValue(
        array $array,
        $value,
        int $member,
        bool $overwrite = true
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

    static public function hasMember(array $array, int $member): bool
    {
        return array_key_exists($member, $array);
    }
}
