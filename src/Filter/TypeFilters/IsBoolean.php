<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsBoolean extends Filter
{
    public function __invoke($using): bool
    {
        return is_bool($using);
    }
}
