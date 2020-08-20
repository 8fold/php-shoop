<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

class TypeAsNumber extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return (int) $using;

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            if (is_float($using)) {
                return (float) $using;
            }
            return (int) $using;

        } elseif (TypeIs::applyWith("collection")->unfoldUsing($using)) {
            if (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
                $using = (array) $using;
            }
            return count($using);

        }
    }
}
