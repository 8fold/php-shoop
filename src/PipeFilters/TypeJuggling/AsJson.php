<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsJson\FromTuple;

class AsJson extends Filter
{
    public function __invoke($using): string
    {
        if (IsJson::apply()->unfoldUsing($using)) {
            return $using;
        }

        if (IsTuple::apply()->unfoldUsing($using)) {
            return FromTuple::apply()->unfoldUsing($using);

        } else {
            // IsObject
            // IsDictionary
            // IsArray
            // IsNumber - loose
            // IsBoolean
            // IsString
            return Shoop::pipe($using, AsTuple::apply(), AsJson::apply())
                ->unfold();
        }
    }
}
