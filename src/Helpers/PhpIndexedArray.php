<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\FluentTypes\Helpers\{
    PhpInt
};

class PhpIndexedArray
{
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
