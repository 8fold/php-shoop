<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Span\FromList as SpanFromList;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromString as AsIntegerFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;

class StringEndsWith extends Filter
{
    private $suffix = "";

    public function __construct(string $suffix = "")
    {
        $this->suffix = $suffix;
    }

    // TODO: PHP 8.0 - str_ends_with()
    // TODO: PHP 8.0 array|string
    public function __invoke(string $using): bool
    {
        $length = AsIntegerFromString::apply()->unfoldUsing($this->suffix);

        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            SpanFromList::applyWith(-$length),
            AsStringFromList::apply(),
            Is::applyWith($this->suffix)
        )->unfold();
    }
}
