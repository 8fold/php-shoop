<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\At\FromArray as AtFromArray;
use Eightfold\Shoop\PipeFilters\At\FromDictionary as AtFromDictionary;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsListOfIntegers;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;

class FromList extends Filter
{
    private $members = "";
    private $useArray = false;

    // TODO: PHP 8.0 - int|float|string|array
    public function __construct(...$members)
    {
        if (IsListOfIntegers::apply()->unfoldUsing($members)) {
            $this->useArray = true;

        } elseif (IsNumber::apply()->unfoldUsing($members)) {
            $this->useArray = true;

        }
        $this->members = $members;
    }

    // TODO: PHP 8.0 - not null -> int|float|string|array|object
    public function __invoke(array $using)
    {
        if ($this->useArray) {
            return AtFromArray::applyWith(...$this->members)->unfoldUsing($using);

        }
        return AtFromDictionary::applyWith(...$this->members)->unfoldUsing($using);
    }
}
