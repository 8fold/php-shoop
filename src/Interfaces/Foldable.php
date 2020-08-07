<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\Interfaces\ShoopedExtensions\PhpMagicMethods;

interface Foldable extends PhpMagicMethods
{
    static public function processedMain($main);

    static public function fold($main, ...$args);

    public function unfold();

    public function value();

    // TODO: Consider a method called "if" - then deprecate
    public function condition($bool, \Closure $closure = null);
}
