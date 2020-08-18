<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\At\FromArray as AtFromArray;
use Eightfold\Shoop\PipeFilters\At\FromDictionary as AtFromDictionary;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromNumber as AsIntegerFromNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromInteger as AsArrayFromInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsDictionary\FromArray as AsDictionaryFromArray;


class FromNumber extends Filter
{
    private $member = 0;
    private $usingArray = false;
    private $startingFrom = 0;

    // TODO: PHP 8.0 - int|float
    public function __construct($member = 0, int $startingFrom = 0)
    {
        if (IsInteger::apply()->unfoldUsing($member)) {
            $this->usingArray = true;
        }
        $this->member = $member;
        $this->startingFrom = $startingFrom;
    }

    // TODO: PHP 8.0 - int|float
    public function __invoke($using)
    {
        if ($this->usingArray) {
            return Shoop::pipe($using,
                AsIntegerFromNumber::apply(),
                AsArrayFromInteger::applyWith($this->startingFrom),
                AtFromArray::applyWith($this->member)
            )->unfold();
        }
        return Shoop::pipe($using,
            AsIntegerFromNumber::apply(),
            AsArrayFromInteger::applyWith($this->startingFrom),
            AsDictionaryFromArray::apply(),
            AtFromDictionary::applyWith($this->member)
        )->unfold();
    }
}
