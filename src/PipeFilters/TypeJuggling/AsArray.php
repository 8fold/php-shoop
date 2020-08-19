<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromBoolean;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromDictionary;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromInteger;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsArray\FromString;

class AsArray extends Filter
{
    public function __invoke($using): array
    {
        if (IsList::applyWith(true)->unfoldUsing($using)) {
            return array_values($using);
        }

        if (IsBoolean::apply()->unfoldUsing($using)) {
            return FromBoolean::apply()->unfoldUsing($using);

        } elseif (IsInteger::apply()->unfoldUsing($using)) {
            return FromInteger::apply()->unfoldUsing($using);

        } elseif (IsDictionary::apply()->unfoldUsing($using)) {
            return FromDictionary::apply()->unfoldUsing($using);

        } elseif (IsString::apply()->unfoldUsing($using)) {
            return FromString::apply()->unfoldUsing($using);

        } elseif (IsNumber::apply()->unfoldUsing($using)) {
            return Shoop::pipe($using,
                AsInteger::apply(),
                AsArray::apply()
            )->unfold();

        } else {
            // IsObject
            // IsTuple
            // IsJson
            return Shoop::pipe($using,
                AsDictionary::apply(),
                AsArray::apply()
            )->unfold();
        }
    }
}
