<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

use Eightfold\Shoop\Foldable\Foldable;

interface Typeable
{
    public function efTypes(): Arrayable;

    public function types(): array;
}
