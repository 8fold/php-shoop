<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\PipeFilters\Contracts\Falsifiable;

interface Comparable
{
    public function is($compare): Falsifiable;

    public function isEmpty(): Falsifiable;

    public function isGreaterThan($compare): Falsifiable;

    public function isGreaterThanOrEqualTo($compare): Falsifiable;

    public function efIs($compare): bool;

    public function efIsEmpty(): bool;

    public function efIsGreaterThan($compare): bool;

    public function efIsGreaterThanOrEqualTo($compare): bool;
}
