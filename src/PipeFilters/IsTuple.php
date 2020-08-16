<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsObject;

class IsTuple extends Filter
{
    /**
     * A Tuple MUST be an instance of stdClass - not an anonymous class.
     */
    public function __invoke($using): bool
    {
        if (! is_object($using) or is_bool($using)) return false;

        return is_a($using, \stdClass::class);
    }
}
