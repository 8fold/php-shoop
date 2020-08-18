<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\At\FromDictionary as AtFromDictionary;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple\FromJson as AsTupleFromJson;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple\FromDictionary as AsTupleFromDictionary;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsJson\FromTuple as AsJsonFromTuple;

class FromJson extends Filter
{
    private $members = [];

    public function __construct(...$members)
    {
        $this->members = $members;
    }

    public function __invoke(string $using)
    {
        $windUp = Shoop::pipe($using,
            AsTupleFromJson::apply(),
            AsDictionaryFromTuple::apply(),
            AtFromDictionary::applyWith(...$this->members),
        )->unfold();

        if (count($this->members) === 1) {
            return $windUp;
        }
        return Shoop::pipe($windUp,
            AsTupleFromDictionary::apply(),
            AsJsonFromTuple::apply()
        )->unfold();
    }
}
