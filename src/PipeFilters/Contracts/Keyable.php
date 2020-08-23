<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\Arrayable;

use Eightfold\Foldable\Foldable;

interface Keyable extends Arrayable
{
    public function asDictionary(): Foldable;

    public function efToDictionary(): array;
}
