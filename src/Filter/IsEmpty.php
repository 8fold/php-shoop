<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsEmpty extends Filter
{
    public function __invoke($using): bool
    {
        if (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                IsEmpty::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            $properties = get_object_vars($using);
            $methods = get_class_methods($using);
            $using = array_merge($properties, $methods);
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                IsEmpty::apply()
            )->unfold();

        } else {
            return empty($using);

        }
    }
}
