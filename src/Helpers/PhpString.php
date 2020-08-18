<?php

namespace Eightfold\Shoop\Helpers;

use Eightfold\Shoop\Helpers\PhpIndexedArray;

class PhpString
{
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

    static public function startsAndEndsWith(string $string, string $start, string $end): bool
    {
        return self::startsWith($string, $start) and self::endsWith($string, $end);
    }

    static public function toBool(string $string): bool
    {
        $bool = empty($string);
        $bool = ! $bool;
        return $bool;
    }
}
