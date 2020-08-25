<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Foldable\Foldable;

use Eightfold\Shoop\PipeFilters\Contracts\Ordered;

trait OrderedImp
{
    public function efIsOrdered(): bool
    {
        if (is_a($this, Ordered::class) and is_a($this, Foldable::class)) {
            return $this->isOrdered()->unfold();
        }
        return false;
    }
}
