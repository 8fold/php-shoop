<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

// TODO: rename to ??
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
