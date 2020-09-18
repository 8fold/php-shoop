<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

/**
 * @todo rename InsertAt, default is append w/ PHP_INT_MAX, -1 allowed to signal prepend
 * (argument for arrays starting at 1, as we could say insertAt(0) instead of insertAt(-1));
 * invocation
 *
 *
 */
class PlusAt extends Filter
{
    public function __invoke($using)
    {
        // if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
        //     TypeIs::applyWith("number")->unfoldUsing($using)
        // ) {
        //     return Apply::plus($this->value)->unfoldUsing($using);

        // } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
        //     if (TypeIs::applyWith("dictionary")->unfoldUsing($using) and
        //         TypeIs::applyWith("integer")->unfoldUsing($this->member)
        //     ) {
        //         $this->member = Apply::prepend("i")->unfoldUsing($this->member);

        //     }

        //     $using[$this->member] = $this->value;

        //     if (TypeIs::applyWith("integer")->unfoldUsing($this->member)) {
        //         return array_values($using);

        //     }
        //     return $using;

        // } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
        //     return Shoop::pipe($using,
        //         TypeAsArray::apply(),
        //         PlusAt::applyWith($this->value, $this->member),
        //         TypeAsString::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
        //     return Shoop::pipe($using,
        //         TypeAsDictionary::apply(),
        //         PlusAt::applyWith($this->value, $this->member),
        //         TypeAsTuple::apply()
        //     )->unfold();

        // } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

        // }
    }

    static private function fromString(
        string $using,
        string $characters = "",
        bool $prepend = false
    ): string
    {
        return ($prepend) ? $characters . $using : $using . $characters;
    }
}
