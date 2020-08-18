<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsStringLowerCased\FromString;

class AsStringLowerCased extends Filter
{
    public function __invoke($using)
    {
        if (IsString::apply()->unfoldUsing($using)) {
            return FromString::apply()->unfoldUsing($using);

        } else {
            return Shoop::pipe($using,
                AsString::apply(),
                AsStringLowerCased::apply())
            ->unfold();
        }
    }
}
