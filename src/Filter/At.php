<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

use Eightfold\Shoop\Filter\Is\IsIdentical;

/**
 * @todo - invocation, applicable type methods
 */
class At extends Filter
{
    public function __invoke($using)
    {
        // $main = $this->main;
        // if (! TypeIs::applyWith("list")->unfoldUsing($this->main)) {
        //     $main = [$this->main];
        // }

        // if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
        //     TypeIs::applyWith("number")->unfoldUsing($using)
        // ) {
        //     // TODO: There should be a way to make this generic -
        //     //      casting to array for dictionary based on whether a given
        //     //      key is an integer or string
        //     return Shoop::pipe($using,
        //         (is_int($main[0]))
        //             ? TypeAsArray::apply()
        //             : TypeAsDictionary::apply(),
        //         At::applyWith($main),
        //     )->unfold();

        // } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
        //     $result = $this->atFromList($using, $main);
        //     if (TypeAsInteger::apply()->unfoldUsing($result) === 1) {
        //         return Apply::from(0, 1)->unfoldUsing($result);
        //         // return array_shift($result); // TODO: Make Filter - First

        //     } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
        //         return TypeAsArray::apply()->unfoldUsing($result);

        //     }
        //     return $result;

        // } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
        //     if (is_string($this->main)) {
        //         return Shoop::pipe($using,
        //             TypeAsDictionary::apply(),
        //             At::applyWith($main)
        //         )->unfold();
        //     }
        //     return Shoop::pipe($using,
        //         TypeAsArray::apply(),
        //         At::applyWith($main)
        //     )->unfold();

        // } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
        //     $result = Shoop::pipe($using,
        //         (is_int($main[0]))
        //             ? TypeAsArray::apply()
        //             : TypeAsDictionary::apply(),
        //         At::applyWith($main)
        //     )->unfold();

        //     if (TypeAsInteger::apply()->unfoldUsing($result) === 1) {
        //         return $result; // TODO: Make Filter - First

        //     }
        //     return TypeAsTuple::apply()->unfoldUsing($result);

        // } else {
        //     return Shoop::pipe($using,
        //         TypeAsArray::apply(),
        //         At::applyWith($this->main)
        //     )->unfold();

        // }
    }

    static public function fromDictionary(array $using, array $members)
    {
        $build = [];
        foreach ($members as $member) {
            if (isset($using[$member])) {
                $build[$member] = $using[$member];

            }
        }

        $count = Count::fromList($build);
        $isOne = IsIdentical::fromNumber($count, 1);
        return ($isOne) ? array_pop($build) : $build;
    }

    static private function fromList(array $using, array $members)
    {
        $build = [];
        foreach ($members as $member) {
            if (isset($using[$member])) {
                $build[$member] = $using[$member];

            }
        }
        return $build;
    }
}
