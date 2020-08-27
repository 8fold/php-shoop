<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

interface Comparable
{
    public function is($compare): Falsifiable;

    public function efIs($compare): bool;

    public function isGreaterThan($compare): Falsifiable;

    public function efIsGreaterThan($compare): bool;

    public function isGreaterThanOrEqualTo($compare): Falsifiable;

    public function efIsGreaterThanOrEqualTo($compare): bool;
}
