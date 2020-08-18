<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Is;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromList as AsIntegerFromList;

class IsListOfStrings extends Filter
{
    public function __invoke(array $using): bool
    {
        return Shoop::pipe($using,
            AsArrayOfStrings::apply(),
            AsIntegerFromList::apply(),
            Is::applyWith(
                AsIntegerFromList::apply()->unfoldUsing($using)
            )
        )->unfold();
    }
}
