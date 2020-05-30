<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\PhpIndexedArray;

class PhpString
{
    static public function afterRemoving(string $string, array $needles = []): string
    {
        return str_replace($needles, "", $string);
    }

    static public function startsWithGet(string $string): bool
    {
        return self::startsWith($string, "get");
    }

    static public function startsWithSet(string $string): bool
    {
        return self::startsWith($string, "set");
    }

    static public function endsWithUnfolded(string $string): bool
    {
        return self::endsWith($string, "Unfolded");
    }

    static public function startsWith(string $string, string $potential): bool
    {
        $length = strlen($potential);
        return substr($string, 0, $length) === $potential;
    }

    static public function endsWith(string $string, string $potential): bool
    {
        $length = -1 * strlen($potential);
        return substr($string, $length) === $potential;
    }

    static public function startsAndEndsWith(string $string, string $start, string $end): bool
    {
        return self::startsWith($string, $start) and self::endsWith($string, $end);
    }

    static public function reversed(string $string): string
    {
        $array = PhpString::toIndexedArray($string);
        $array = PhpIndexedArray::reversed($array, true);
        return implode("", $array);
    }

// - Type Juggle
    static public function toIndexedArray(string $string): array
    {
        return preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
    }

    static public function toBool(string $string): bool
    {
        $bool = empty($string);
        $bool = ! $bool;
        return $bool;
    }

    static public function toAssociativeArray(string $string): array
    {
        $array = self::toIndexedArray($string);
        $dictionary = PhpIndexedArray::toAssociativeArray($array);
        return $dictionary;
    }

    static public function toInt(string $string): int
    {
        $int = intval($string);
        return $int;
    }

    static public function toObject(string $string): object
    {
        $object = new \stdClass();
        $object->string = $string;
        return $object;
    }

    static public function hasMember(string $string, int $member): bool
    {
        $dictionary = self::toIndexedArray($string);
        return array_key_exists($member, $dictionary);
    }
}
