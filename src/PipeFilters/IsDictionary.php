<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\IsArray;

class IsDictionary extends Filter
{
    public function __invoke($using): bool
    {
        if (is_bool($using) or is_string($using)) return false;

        if (!is_array($using)) return false;

        return (IsArray::apply()->unfoldUsing($using)) ? false : true;
    }
}
