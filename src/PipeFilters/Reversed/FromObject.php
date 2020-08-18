<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Reversed\FromTuple as ReversedFromTuple;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple\FromObject as AsTupleFromObject;

class FromObject extends Filter
{
    public function __invoke(object $using): object
    {
        if (IsTuple::apply()->unfoldUsing($using)) {
            return $using;
        }
        return Shoop::pipe($using,
            AsTupleFromObject::apply(),
            ReversedFromTuple::apply()
        )->unfold();
    }
}
