<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Span;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Span\FromList as SpanFromList;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString as AsArrayFromString;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsString\FromList as AsStringFromList;


class FromString extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    public function __construct(int $start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke(string $using): string
    {
        if (IsJson::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsDictionaryFromJson::applyWith(),
                SpanFromDictionary::applyWith($this->start, $this->length),
                AsJsonFromDictionary::apply()
            )->unfold();
        }
        return Shoop::pipe($using,
            AsArrayFromString::apply(),
            SpanFromList::applyWith($this->start, $this->length),
            AsStringFromList::apply()
        )->unfold();
    }
}
