<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\At;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\At\FromArray as AtFromArray;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;

class FromString extends Filter
{
    private $members = 0;

    // TODO: PHP 8.0 - array|null
    public function __construct(int ...$members)
    {
        $this->members = $members;
    }

    public function __invoke(string $using): string
    {
        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            AtFromArray::applyWith(...$this->members),
            AsStringFromList::apply()
        )->unfold();
    }
}
