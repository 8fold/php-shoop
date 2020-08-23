<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

trait FalsifiableImp
{
    public function efToBool(): bool
    {
        return $this->asBoolean()->unfold();
    }
}
