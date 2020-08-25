<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Foldable\Foldable;

interface Falsifiable
{
    public function asBoolean(): Foldable;

    public function efToBoolean(): bool;
}
