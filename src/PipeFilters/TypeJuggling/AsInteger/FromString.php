<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromArray as AsIntegerFromArray;

class FromString extends Filter
{
    public function __invoke(string $using): int
    {
        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            AsIntegerFromArray::apply()
        )->unfold();
    }
}
