<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsCollection extends Filter
{
    public function __invoke($using): bool
    {
        if (IsBoolean::apply()->unfoldUsing($using)) {
            return false;
        }

        if (IsList::apply()->unfoldUsing($using)) {
            return true;
        }

        if (IsTuple::apply()->unfoldUsing($using)) {
            return true;
        }

        return false;
    }
}
