<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsNumber extends Filter
{
    public function __invoke($using): bool
    {
        return is_float($using);
    }
}
