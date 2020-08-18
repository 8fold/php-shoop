<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\{
    PhpInt
};

class PhpIndexedArray
{
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

    static public function hasMember(array $array, int $member): bool
    {
        return array_key_exists($member, $array);
    }
}
