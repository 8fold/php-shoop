<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Foldable;
use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

/**
 * @todo - invocation
 */
class Plus extends Filter
{
    public function __invoke($using)
    {
        // if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
        //     return Shoop::pipe($using,
        //         TypeAsInteger::apply(),
        //         Plus::applyWith($this->value),
        //         TypeAsBoolean::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
        //     if (! TypeIs::applyWith("list")->unfoldUsing($this->value)) {
        //         $this->value = [$this->value];
        //     }

        //     $int = array_sum($this->value);
        //     return $using + $int;

        // } elseif (TypeIs::applyWith("list")->unfoldUsing($using) or
        //     TypeIs::applyWith("string")->unfoldUsing($using) or
        //     TypeIs::applyWith("tuple")->unfoldUsing($using) or
        //     TypeIs::applyWith("object")->unfoldUsing($using)
        // ) {
        //     return Apply::append($this->value)->unfoldUsing($using);

        // } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
        //     // TODO: Use Append
        //     if (TypeIs::applyWith("tuple")->unfoldUsing($this->value)) {
        //         return Shoop::pipe($using,
        //             TypeAsDictionary::apply(),
        //             Plus::applyWith(
        //                 TypeAsDictionary::apply()->unfoldUsing($this->value)
        //             ),
        //             TypeAsTuple::apply()
        //         )->unfold();

        //     } elseif (! is_array($this->value)) {
        //         $this->value = [$this->value];

        //     }

        //     return Shoop::pipe($using,
        //         TypeAsDictionary::apply(),
        //         Plus::applyWith(
        //             TypeAsDictionary::apply()->unfoldUsing($this->value)
        //         ),
        //         TypeAsTuple::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
        //     // TODO: Use Append
        //     if (! is_array($this->value)) {
        //         $this->value = [$this->value];
        //     }
        //     return Shoop::pipe($using,
        //         TypeAsTuple::apply(),
        //         Plus::applyWith($this->value)
        //     )->unfold();

        // }
    }
}
