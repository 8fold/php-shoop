<?php

namespace Eightfold\Shoop\FilterContracts;

use Eightfold\Shoop\Foldable\Foldable;

interface Typeable
{
    public function types(): array;
}
