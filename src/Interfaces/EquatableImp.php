<?php

namespace Eightfold\Shoop\Interfaces;

trait EquatableImp
{
    public function isSameAs(Equatable $compare): ESBool
    {
        return ESBool::init($this->value === $compare->unwrap());
    }

    public function isDifferentThan(Equatable $compare): ESBool
    {
        return $this->isSameAs($compare)->toggle();
    }
}
