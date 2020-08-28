<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

class TypeAsJson extends Filter
{
    public function __invoke($using)
    {
        $tuple = TypeAsTuple::apply()->unfoldUsing($using);
        return json_encode($tuple);
    }
}
