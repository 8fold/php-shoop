<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsInteger extends Filter
{
    public function __invoke($using): bool
    {
        return (is_integer($using)) ? true : floor($using) === $using;
    }
}
