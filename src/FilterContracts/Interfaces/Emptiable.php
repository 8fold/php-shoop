<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

interface Emptiable
{
    public function isEmpty(): Falsifiable;

    public function efEmpty(): bool;
}
