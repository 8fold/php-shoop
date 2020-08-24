<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use Eightfold\Shoop\FluentTypes\ESInteger;
use Eightfold\Shoop\Foldable\Foldable;

interface MathOperations
{
    public function plus($value, $at = ""): Foldable;
}
