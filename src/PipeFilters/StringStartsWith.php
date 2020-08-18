<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Is;
use Eightfold\Shoop\PipeFilters\Span\FromList as SpanFromList;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromString as AsIntegerFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;

class StringStartsWith extends Filter
{
    private $prefix = "";

    public function __construct(string $prefix = "")
    {
        $this->prefix = $prefix;
    }

    public function __invoke(string $using): bool
    {
        $length = AsIntegerFromString::apply()->unfoldUsing($this->prefix);
        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            SpanFromList::applyWith(0, $length),
            AsStringFromList::apply(),
            Is::applyWith($this->prefix)
        )->unfold();
    }
}
