<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Reversed extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return ! $using;

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return $using * -1;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            return array_reverse($using);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return strrev($using);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using) or
            TypeIs::applyWith("object")->unfoldUsing($using)
        ) {
            $initial = Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Reversed::apply(),
                TypeAsTuple::apply()
            )->unfold();
            if (TypeIs::applyWith("json")->unfoldUsing($using)) {
                return TypeAsJson::apply()->unfoldUsing($initial);

            }
            return $initial;

        }
    }
}
