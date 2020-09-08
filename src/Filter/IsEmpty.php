<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

use Eightfold\Shoop\FilterContracts\Interfaces\Emptiable;

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
            if (is_a($using, Emptiable::class)) {
                return $using->efIsEmpty();
            }

            $properties = get_object_vars($using);
            $methods = get_class_methods($using);
            $using = Apply::concatenate($methods)->unfoldUsing($properties);
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                IsEmpty::apply()
            )->unfold();

        } else {
            return empty($using);

        }
    }
}
