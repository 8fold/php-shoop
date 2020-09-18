<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

/**
 * @todo invocation, implement __callStatic to reach HasMethods: Has::methods()->unfoldUsing($using)
 *
 * Return whether a given sequence `Has` a given value.
 *
 * All non-list types are converted to their `array` representation.
 *
 * Strings use a case-sensitive comparison and strict type comparison.
 *
 * PHP Standard Library: `in_array`
 */
class Has extends Filter
{
    public function __invoke($using)
    {
    }

    static public function fromString(string $using, string $needle): bool
    {
        return strpos($using, $needle) !== false;
    }
}
