<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Foldable\Foldable;

interface Ordered
{
    public function isOrdered(): Foldable;

    public function efIsOrdered(): bool;
}
