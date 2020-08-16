<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class UsesStringMembers extends Filter
{
    public function __invoke($using): bool
    {
        return (IsObject::apply()->unfoldUsing($using) or
            IsTuple::apply()->unfoldUsing($using) or
            IsDictionary::apply()->unfoldUsing($using)
        );
    }
}
