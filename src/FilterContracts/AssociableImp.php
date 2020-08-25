<?php

namespace Eightfold\Shoop\Filter\Contracts;

use Eightfold\Shoop\FilterContracts\ArrayableImp;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FilterContracts\Keyable;

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
