<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

interface Comparable
{
    public function is($compare): Comparable;

    public function isEmpty(): Comparable;

    public function isGreaterThan($compare): Comparable;

    public function isGreaterThanOrEqualTo($compare): Comparable;

    public function efIs($compare): bool;

    public function efIsEmpty(): bool;

    public function efIsGreaterThan($compare): bool;

    public function efIsGreaterThanOrEqualTo($compare): bool;
}
