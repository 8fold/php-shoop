<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

interface Falsifiable
{
    public function asBoolean(): Falsifiable;

    public function efToBool(): bool;
}
