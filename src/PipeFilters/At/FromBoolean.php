<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Minus;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Minus\FromNumber as MinusFromNumber;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromNumber as AsIntegerFromBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean\FromNumber as AsBooleanFromNumber;

class FromBoolean extends Filter
{
    public function __invoke(bool $using): bool
    {
        return Shoop::pipe($using,
            AsIntegerFromBoolean::apply(),
            MinusFromNumber::applyWith($this->main),
            AsBooleanFromNumber::apply()
        )->unfold();
    }
}
