<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class IsList extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_array($using)) return false;

        if (IsDictionary::apply()->unfoldUsing($using) or IsArray::apply()->unfoldUsing($using)) return true;

        return false;
    }
}
