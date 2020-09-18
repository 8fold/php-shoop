<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

/**
 * @todo rename to RemoveAt, invocation, type-specific methods
 */
class MinusAt extends Filter
{
    public function __invoke($using)
    {
        // if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
        //     if (TypeIs::applyWith("integer")->unfoldUsing($this->main)) {
        //         return Shoop::pipe($using,
        //             TypeAsArray::apply(),
        //             MinusAt::applyWith($this->main),
        //             TypeAsArray::apply(),
        //             At::applyWith(0)
        //         )->unfold();

        //     }
        //     return Shoop::pipe($using,
        //         TypeAsDictionary::apply(),
        //         MinusAt::applyWith($this->main),
        //         TypeAsArray::apply(),
        //         At::applyWith(0)
        //     );

        // } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
        //     return Minus::applyWith($this->main)->unfoldUsing($using);

        // } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
        //     if (TypeIs::applyWith("array")->unfoldUsing($using)) {
        //         unset($using[$this->main]);
        //         return array_values($using);

        //     }
        //     unset($using[$this->main]);
        //     return $using;

        // } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
        //     return Shoop::pipe($using,
        //         TypeAsArray::apply(),
        //         MinusAt::applyWith($this->main),
        //         TypeAsString::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
        //     return Shoop::pipe($using,
        //         TypeAsDictionary::apply(),
        //         MinusAt::applyWith($this->main),
        //         TypeAsTuple::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
        //     var_dump(__FILE__);
        //     die("object");

        // }
    }
}
