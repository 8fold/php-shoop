<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use Eightfold\Shoop\FluentTypes\ESInt;
use Eightfold\Shoop\Foldable\Foldable;

interface MathOperations
{
    public function plus(...$args): Foldable;

    public function minus(...$args): Foldable;

    public function multiply($int): Foldable;

    public function divide(
        $divisor = 0,
        $includeEmpties = true,
        $limit = PHP_INT_MAX
    ): Foldable;
}
