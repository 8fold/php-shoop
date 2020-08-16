<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsEmpty extends Filter
{
    public function __invoke($using): bool
    {
        if (IsTuple::apply()->unfoldUsing($using)) {
            return ! Shoop::pipe($using, AsBoolean::apply())->unfold();

        }
        return empty($using);
    }
}
