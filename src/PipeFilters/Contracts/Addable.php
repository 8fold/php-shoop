<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Foldable\Foldable;

interface Addable
{
    public function plus($value, $at = ""): Foldable;
}
