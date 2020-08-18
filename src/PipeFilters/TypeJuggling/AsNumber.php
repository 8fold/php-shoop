<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsJson;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsNumber\FromInteger;

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
