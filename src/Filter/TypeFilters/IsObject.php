<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsObject extends Filter
{
    public function __invoke($using): bool
    {
        return (! is_object($using))
            ? false
            : ! IsTuple::apply()->unfoldUsing($using);
    }
}
