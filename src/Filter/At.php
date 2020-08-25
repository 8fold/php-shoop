<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class At extends Filter
{
    public function __invoke($using)
    {
        $main = $this->main;
        if (! TypeIs::applyWith("list")->unfoldUsing($this->main)) {
            $main = [$this->main];
        }

        if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
            TypeIs::applyWith("number")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                (is_int($main[0]))
                    ? TypeAsArray::apply()
                    : TypeAsDictionary::apply(),
                At::applyWith($main),
            )->unfold();

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $result = $this->atFromList($using, $main);
            if (TypeAsInteger::apply()->unfoldUsing($result) === 1) {
                return array_shift($result); // TODO: Make Filter - First

            } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
                return TypeAsArray::apply()->unfoldUsing($result);

            }
            return $result;

        // } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                At::applyWith($main),
                TypeAsString::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            $result = Shoop::pipe($using,
                (is_int($main[0]))
                    ? TypeAsArray::apply()
                    : TypeAsDictionary::apply(),
                At::applyWith($main)
            )->unfold();

            if (TypeAsInteger::apply()->unfoldUsing($result) === 1) {
                return $result; // TODO: Make Filter - First

            }
            return TypeAsTuple::apply()->unfoldUsing($result);

        } else {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                At::applyWith($this->main)
            )->unfold();

        }
    }

    static private function atFromList(array $using, array $members)
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
