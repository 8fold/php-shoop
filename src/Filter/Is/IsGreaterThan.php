<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\Is;

use Eightfold\Foldable\Filter;

/**
 * @todo invocation
 */
class IsGreaterThan extends Filter
{
    public function __invoke($using): bool
    {
    }

    // TODO: PHP 8 - int|float, int|float
    static public function fromNumber($using, $compare): bool
    {
        return $using > $compare;
    }
}
