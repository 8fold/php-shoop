<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\Is;

use Eightfold\Foldable\Filter;

/**
 * @group invocation
 *
 * @todo IsIdenticalTo and invocation
 */
class IsIdenticalTo extends Filter
{
    public function __invoke($using): bool
    {
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
