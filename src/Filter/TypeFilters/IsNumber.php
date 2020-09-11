<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsNumber extends Filter
{
    public function __invoke($using): bool
    {
        return ! is_string($using) and is_numeric($using);
    }
}
