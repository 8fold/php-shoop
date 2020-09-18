<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Is\IsIdentical;

/**
 * @todo - invocation
 */
class StartsWith extends Filter
{
    public function __invoke($using): bool
    {
    }

    static public function fromString(string $using, string $prefix): bool
    {
        $prefixLength = Count::fromString($prefix);
        $usingFirst   = First::fromString($using, $prefixLength);
        return IsIdentical::fromString($usingFirst, $prefix);
    }
}
