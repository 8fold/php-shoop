<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

trait CountableImp
{
    public function efToInteger(): int
    {
        if (is_a($this->main, Countable::class)) {
            return $this->main->asInteger();
        }
        return TypeAsInteger::apply()->unfoldUsing($this->main);
    }

    public function count(): int // Countable
    {
        return $this->efToInteger();
    }
}
