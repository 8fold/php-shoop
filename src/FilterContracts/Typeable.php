<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Foldable\Foldable;

interface Typeable
{
    public function types(): array;
}
