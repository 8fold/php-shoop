<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

interface Falsifiable
{
    public function boolean(): Falsifiable;

    public function efToBool(): bool;
}
