<?php

namespace Eightfold\Shoop\FilterContracts;

use Eightfold\Shoop\Foldable\Foldable;

interface Addable
{
    public function plus($value, $at = ""): Addable;
}
