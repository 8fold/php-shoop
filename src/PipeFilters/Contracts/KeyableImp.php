<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\PipeFilters\Contracts\Keyable;

trait KeyableImp
{
    use ArrayableImp;

    public function efToDictionary(): array
    {
        if (is_a($this, Keyable::class) and is_a($this, Foldable::class)) {
            // TODO: Should do a check to make sure returning Shoop dictionary, not
            //      mixed keys.
            return $this->asDictionary()->unfold();
        }
        return [];
    }
}
