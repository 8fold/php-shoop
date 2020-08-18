<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Minus;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Minus\FromList as MinusFromList;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple\FromDictionary as AsTupleFromDictionary;

class FromTuple extends Filter
{
    public function __invoke(object $using): object
    {
        if (IsObject::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsTupleFromObject::applyWith(),
                FromTuple::applyWith(...$this->args(true))
            )->unfold();
        }
        return Shoop::pipe($using,
            AsDictionaryFromTuple::applyWith(),
            MinusFromList::applyWith(...$this->args(true)),
            AsTupleFromDictionary::apply()
        )->unfold();
    }
}
