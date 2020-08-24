<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces\ShoopedExtensions;

interface PhpMagicMethods
{
// TODO: Reinstitute
    static public function startsWithGet(string $string): bool;

    static public function startsWithSet(string $string): bool;

    static public function endsWithUnfolded(string $string): bool;

    static public function startsAndEndsWith(
        string $string,
        string $start,
        string $end
    ): bool;

    public function __call(string $name, array $args = []);

    public function __get($name);

    public function get($member = 0);

    public function getUnfolded($name);

    public function set($value, $member = null, $overwrite = true);
}
