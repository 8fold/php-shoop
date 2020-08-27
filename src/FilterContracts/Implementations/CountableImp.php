<?php

namespace Eightfold\Shoop\Filter\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FilterContracts\Interfaces\Countable;

trait CountableImp
{
    public function efToInteger(): int
    {
        if (is_a($this, Countable::class) and is_a($this, Foldable::class)) {
            return $this->asInteger()->unfold();

        }
        return 0;
    }

    public function count(): int // Countable
    {
        return $this->efToInteger();
    }
}
