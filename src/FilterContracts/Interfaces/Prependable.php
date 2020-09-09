<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

use Eightfold\Shoop\Foldable\Foldable;

interface Prependable
{
    public function prepend($value): Prependable;
}
