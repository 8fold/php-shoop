<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsTuple;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsListOfIntegers;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromDictionary as AsArrayFromDictionary;
use Eightfold\Shoop\PipeFilters\At\FromArray as AtFromArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary\FromArray as AsDictionaryFromArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsTuple\FromDictionary as AsTupleFromDictionary;

class FromTuple extends Filter
{
    private $useArray = false;
    private $members = 0;

    // TODO: PHP 8.0 - int|float|string
    public function __construct(...$members)
    {
        if (IsListOfIntegers::apply()->unfoldUsing($members)) {
            $this->useArray = true;

        } elseif (IsNumber::apply()->unfoldUsing($members)) {
            $this->useArray = true;

        }
        $this->members = $members;
    }

    public function __invoke(object $using): object
    {
        if ($this->useArray) {
            return Shoop::pipe($using,
                AsDictionaryFromTuple::apply(),
                AsArrayFromDictionary::apply(),
                AtFromArray::applyWith(...$this->members),
                AsDictionaryFromArray::apply(),
                AsTupleFromDictionary::apply()
            )->unfold();

        }
        return Shoop::pipe($using,
            AsDictionaryFromTuple::apply(),
            AtFromDictionary::applyWith(...$this->members),
            AsTupleFromDictionary::apply()
        )->unfold();
    }
}
