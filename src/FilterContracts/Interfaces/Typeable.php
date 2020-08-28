<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

use Eightfold\Shoop\Foldable\Foldable;

interface Typeable
{
    public function types(): Arrayable;

    public function efTypes(): array;
}
