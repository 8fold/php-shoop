<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

class IsString extends Filter
{
    public function __invoke($using): bool
    {
        return (! is_string($using))
            ? false
            : ! IsJson::apply()->unfoldUsing($using);
    }
}
