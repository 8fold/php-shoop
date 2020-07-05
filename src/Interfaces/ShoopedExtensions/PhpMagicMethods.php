<?php

namespace Eightfold\Shoop\Interfaces\ShoopedExtensions;

interface PhpMagicMethods
{
    public function __call(string $name, array $args = []);

    public function __get($name);

    public function get($member = 0);

    public function getUnfolded($name);

    public function set($value, $member = null, $overwrite = true);

    public function __toString(): string;

    public function __debugInfo();
}
