<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsInteger\FromArray;
use Eightfold\Shoop\PipeFilters\AsInteger\FromNumber;

class AsInteger extends Filter
{
    public function __invoke($using): int
    {
        if (IsInteger::apply()->unfoldUsing($using)) return $using;

        if (IsList::apply()->unfoldUsing($using)) {
            return FromArray::apply()->unfoldUsing($using);

        } elseif (IsNumber::apply()->unfoldUsing($using) or
            IsBoolean::apply()->unfoldUsing($using)
        ) {
            return FromNumber::apply()->unfoldUsing($using);

        } else {
            // IsObject
            // IsTuple
            // IsJson
            // IsString
            return Shoop::pipe($using,
                AsArray::apply(),
                AsInteger::apply()
            )->unfold();
        }
    }
}
