<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsObject;

use Eightfold\Shoop\PipeFilters\Reversed\FromList as ReversedFromList;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\AsTuple\FromDictionary as AsTupleFromDictionary;

class FromTuple extends Filter
{
    public function __invoke(object $using): object
    {
        if (IsObject::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsTupleFromObject::apply(),
                FromTuple::apply()
            )->unfold();
        }

        return Shoop::pipe($using,
            AsDictionaryFromTuple::apply(),
            ReversedFromList::apply(),
            AsTupleFromDictionary::apply()
        )->unfold();
    }
}
