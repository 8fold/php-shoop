<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESInt;
use Eightfold\Shoop\Interfaces\Foldable;

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
