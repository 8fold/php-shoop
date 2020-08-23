<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp;

trait KeyableImp
{
    use ArrayableImp;

    public function efToDictionary(): array
    {
        // TODO: Should do a check to make sure returning Shoop dictionary, not
        //      mixed keys.
        return $this->asDictionary()->unfold();
    }
}
