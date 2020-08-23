<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\Arrayable;

interface Keyable extends Arrayable
{
    public function asDictionary(): Keyable;

    public function efToDictionary(): array;
}
