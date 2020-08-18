<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Span;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsJson;

use Eightfold\Shoop\PipeFilters\AsTuple\FromJson as AsTupleFromJson;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\Span\FromList as SpanFromList;
use Eightfold\Shoop\PipeFilters\AsTuple\FromDictionary as AsTupleFromDictionary;
use Eightfold\Shoop\PipeFilters\AsJson\FromTuple as AsJsonFromTuple;

class FromJson extends Filter
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
        if (! IsJson::apply()->unfoldUsing($using)) {
            return "";
        }
        return Shoop::pipe($using,
            AsTupleFromJson::apply(),
            AsDictionaryFromTuple::apply(),
            SpanFromList::applyWith($this->start, $this->length),
            AsTupleFromDictionary::apply(),
            AsJsonFromTuple::apply()
        )->unfold();
    }
}
