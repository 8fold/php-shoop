<?php

namespace Eightfold\Shoop\Filter\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FilterContracts\Falsifiable;

trait FalsifiableImp
{
    public function efToBoolean(): bool
    {
        if (is_a($this, Falsifiable::class) and is_a($this, Foldable::class)) {
            return $this->asBoolean()->unfold();
        }
        return false;
    }
}
