<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Reversed\FromList as ReversedFromList;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;

class FromString extends Filter
{
    public function __invoke(string $using): string
    {
        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            ReversedFromList::apply(),
            AsStringFromList::apply()
        )->unfold();
    }
}
