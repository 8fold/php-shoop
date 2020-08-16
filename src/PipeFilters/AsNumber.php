<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use \stdClass;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\IsJson;
use Eightfold\Shoop\PipeFilters\AsNumber\FromInteger;

class AsNumber extends Filter
{
    // TODO: I really don't like that this is order dependent to avoid infinite loop.
    public function __invoke($using): float
    {
        if (IsNumber::apply()->unfoldUsing($using)) return $using;

        if (IsInteger::apply()->unfoldUsing($using) or
            IsBoolean::apply()->unfoldUsing($using)
        ) {
            return FromInteger::apply()->unfoldUsing($using);

        } else {
            // IsArray
            // IsDictionary
            // IsTuple
            // IsObject
            // IsJson
            // IsString
            return Shoop::pipe($using,
                AsInteger::apply(),
                AsNumber::apply()
            )->unfold();
        }
    }
}
