<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;

class TypeAsBoolean extends Filter
{
    public function __invoke($using): bool
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return $using;

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return (bool) $using;

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            return (is_a($using, Falsifiable::class))
                ? $using->efToBoolean()
                : (bool) $using;

        } else {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                TypeAsBoolean::apply()
            )->unfold();

        }
    }
}
