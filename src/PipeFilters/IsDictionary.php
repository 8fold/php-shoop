<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\IsArray;

class IsDictionary extends Filter
{
    public function __invoke(array $using): bool
    {
        return (IsArray::apply()->unfoldUsing($using)) ? false : true;
    }
}
