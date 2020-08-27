<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

interface Emptiable
{
    public function isEmpty(): Falsifiable;

    public function efIsEmpty(): bool;
}
