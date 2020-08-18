<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Span;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\IsObject;

use Eightfold\Shoop\PipeFilters\AsDictionary\FromTuple as AsDictionaryFromTuple;
use Eightfold\Shoop\PipeFilters\Span\FromList as SpanFromList;
use Eightfold\Shoop\PipeFilters\AsTuple\FromDictionary as AsTupleFromDictionary;

class FromTuple extends Filter
{
    private $start = 0;
    private $length = PHP_INT_MAX;

    public function __construct(int $start = 0, int $length = PHP_INT_MAX)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function __invoke(object $using): object
    {
        if (IsObject::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsTupleFromObject::applyWith(),
                FromTuple::applyWith($this->start, $this->length)
            )->unfold();
        }
        return Shoop::pipe($using,
            AsDictionaryFromTuple::applyWith(),
            SpanFromList::applyWith($this->start, $this->length),
            AsTupleFromDictionary::apply()
        )->unfold();
    }
}
