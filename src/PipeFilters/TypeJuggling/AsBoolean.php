<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean\FromNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean\FromObject;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean\FromJson;

class AsBoolean extends Filter
{
    public function __invoke($using): Bool
    {
        // TODO: Had to specify order of calls here as well.
        if (IsBoolean::apply()->unfoldUsing($using)) {
            return $using;
        }

        if (IsNumber::apply()->unfoldUsing($using)) {
            return FromNumber::apply()->unfoldUsing($using);

        } elseif (IsObject::apply()->unfoldUsing($using) or
            IsTuple::apply()->unfoldUsing($using)
        ) {
            return FromObject::apply()->unfoldUsing($using);

        } elseif (IsJson::apply()->unfoldUsing($using)) {
            return FromJson::apply()->unfoldUsing($using);

        } else {
            // IsNumber
            // IsArray
            // IsDictionary
            // IsString
            return Shoop::pipe($using,
                AsNumber::apply(),
                AsBoolean::apply()
            )->unfold();

        }
    }
}
