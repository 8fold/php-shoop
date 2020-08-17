<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class IsList extends Filter
{
    public function __invoke($using): bool
    {
        return is_array($using);
    }
}
