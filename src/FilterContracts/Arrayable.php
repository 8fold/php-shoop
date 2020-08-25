<?php

namespace Eightfold\Shoop\FilterContracts;

use Eightfold\Shoop\FilterContracts\Associable;

interface Arrayable extends Associable
{
    // PHP 8.0 - Arrayable|array
    public function asArray(
        $start = 0,
        bool $includeEmpties = true,
        int $limit = PHP_INT_MAX
    ): Arrayable;

    public function efToArray(): array;
}
