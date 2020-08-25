<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Foldable\Foldable;

interface Ordered
{
    public function isOrdered(): Foldable;

    public function efIsOrdered(): bool;
}
