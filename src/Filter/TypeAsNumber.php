<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class TypeAsNumber extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
            TypeIs::applyWith("integer")->unfoldUsing($using)
        ) {
            return (int) $using;

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return (float) $using;

        } elseif (TypeIs::applyWith("collection")->unfoldUsing($using)) {
            if (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
                $using = (array) $using;
            }
            return count($using);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            $array = TypeAsArray::apply()->unfoldUsing($using);
            return TypeAsNumber::apply()->unfoldUsing($array);

        }
    }
}
