<?php

namespace Eightfold\Shoop\Interfaces;

use \Closure;

use Eightfold\Shoop\Interfaces\ShoopedExtensions\PhpMagicMethods;

interface Foldable extends PhpMagicMethods
{
    static public function processedMain($main);

    // TODO: Return type can't be an interface
    static public function fold($main, ...$args): Foldable;

    public function unfold();

    // TODO: Consider a method called "if" - then deprecate
    // TODO: Can this be made to always return a Foldable?? Don't think so.
    public function condition($bool, Closure $closure = null);
}
