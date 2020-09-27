<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Is\IsIdenticalTo;

/**
 * @todo - invocation
 */
class EndsWith extends Filter
{
    public function __invoke(string $using): bool
    {
    }

    static public function fromString(string $using, string $suffix): bool
    {
        $prefixLength = Count::fromString($suffix);
        $usingFirst   = Last::fromString($using, $prefixLength);
        return IsIdenticalTo::fromString($usingFirst, $suffix);
    }
}
