<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

// TODO: Increase type-safety by using established type-check pattern
class Is extends Filter
{
    private $compare = "";

    public function __construct($compare = "")
    {
        $this->compare = $compare;
    }

    public function __invoke($using): bool
    {
        return $using === $this->compare;
    }

    // TODO: PHP 8.0 int|float, int|float
    static public function fromNumber($number, $comparison): bool
    {
        return $number === $comparison;
    }

    static public function fromString(string $number, string $comparison): bool
    {
        return $number === $comparison;
    }

    static public function fromList(array $first, array $comparison): bool
    {
        return $first === $comparison;
    }
}
