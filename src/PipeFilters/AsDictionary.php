<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromArray;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromBoolean;
use Eightfold\Shoop\PipeFilters\AsDictionary\FromTuple;

class AsDictionary extends Filter
{
    public function __invoke($using): array
    {
        if (IsDictionary::apply()->unfoldUsing($using)) return $using;

        if (IsBoolean::apply()->unfoldUsing($using)) {
            return FromBoolean::apply()->unfoldUsing($using);

        } elseif (IsArray::apply()->unfoldUsing($using)) {
            return FromArray::applyWith(...$this->args(true))
                ->unfoldUsing($using);

        } elseif (IsTuple::apply()->unfoldUsing($using)) {
            return FromTuple::apply()->unfoldUsing($using);

        } elseif (IsNumber::apply()->unfoldUsing($using) or
            IsInteger::apply()->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                AsArray::apply(),
                AsDictionary::apply()
            )->unfold();

        } else {
            // IsObject
            // IsJson
            // IsString
            return Shoop::pipe($using,
                AsTuple::apply(),
                AsDictionary::apply()
            )->unfold();

        }
    }
}
