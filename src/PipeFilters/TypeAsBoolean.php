<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\FluentTypes\Contracts\Falsifiable;

class TypeAsBoolean extends Filter
{
    public function __invoke($using): bool
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return $using;

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return (bool) $using;

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using) and
            is_a($using, Falsifiable::class)
        ) {
            return $using->efToBool();

        } else {
            $int = TypeAsInteger::apply()->unfoldUsing($using);
            return TypeAsBoolean::apply()->unfoldUsing($int);

        }
    }
}
