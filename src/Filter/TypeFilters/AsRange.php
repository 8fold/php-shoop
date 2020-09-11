<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class AsRange extends Filter
{
    public function __invoke($using): array
    {
    }

    // TODO: PHP 8.0 - int|float, int|float
    static public function fromNumber($start, $end): array
    {
        return range($start, $end);
    }
}
