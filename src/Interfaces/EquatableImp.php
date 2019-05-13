<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;
use Eightfold\Shoop\Interfaces\Equatable;

trait EquatableImp
{
    public function isSameAs(Equatable $compare): ESBool
    {
        return ESBool::wrap($this->value === $compare->unwrap());
    }

    public function isDifferentThan(Equatable $compare): ESBool
    {
        return $this->isSameAs($compare)->toggle();
    }
}
