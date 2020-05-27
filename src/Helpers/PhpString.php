<?php

namespace Eightfold\Shoop\Helpers;

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
}
