<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;

use Eightfold\Shoop\PipeFilters\AsTuple\FromJson as AsTupleFromJson;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\Reversed\FromList as ReversedFromList;
use Eightfold\Shoop\PipeFilters\AsTuple\FromDictionary as AsTupleFromDictionary;
use Eightfold\Shoop\PipeFilters\AsJson\FromTuple as AsJsonFromTuple;

class FromJson extends Filter
{
    public function __invoke(string $using): string
    {
        if (! IsJson::apply()->unfoldUsing($using)) {
            return new stdClass;
        }
        return Shoop::pipe($using,
            AsTupleFromJson::apply(),
            AsDictionaryFromTuple::apply(),
            ReversedFromList::apply(),
            AsTupleFromDictionary::apply(),
            AsJsonFromTuple::apply()
        )->unfold();
    }
}
