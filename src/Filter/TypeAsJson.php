<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class TypeAsJson extends Filter
{
    public function __invoke($using)
    {
        $tuple = TypeAsTuple::apply()->unfoldUsing($using);
        return json_encode($tuple);
    }
}
