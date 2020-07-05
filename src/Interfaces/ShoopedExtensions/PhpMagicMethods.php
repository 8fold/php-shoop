<?php

namespace Eightfold\Shoop\Interfaces\ShoopedExtensions;

interface PhpMagicMethods
{
    public function __call(string $name, array $args = []);

    public function __get($name);

    public function __toString(): string;

    public function __debugInfo();
}
