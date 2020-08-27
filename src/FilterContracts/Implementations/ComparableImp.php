<?php

namespace Eightfold\Shoop\Filter\Contracts;

use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

trait ComparableImp
{
    public function efIs($compare): bool
    {
        if (is_a($this, Falsifiable::class) and is_a($this, Foldable::class)) {
            return $this->is($compare)->unfold();
        }
        return false;
    }

    public function efIsEmpty(): bool
    {
        if (is_a($this, Falsifiable::class) and is_a($this, Foldable::class)) {
            return $this->isEmpty()->unfold();
        }
        return false;
    }

    public function efIsGreaterThan($compare): bool
    {
        if (is_a($this, Falsifiable::class) and is_a($this, Foldable::class)) {
            return $this->isGreaterThan($compare)->unfold();
        }
        return false;
    }

    public function efIsGreaterThanOrEqualTo($compare): bool
    {
        if (is_a($this, Falsifiable::class) and is_a($this, Foldable::class)) {
            return $this->isGreaterThanOrEqualTo()->unfold();
        }
        return false;
    }
}
