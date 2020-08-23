<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class At extends Filter
{
    public function __invoke($using)
    {
        if (! TypeIs::applyWith("list")->unfoldUsing($this->main)) {
            $this->main = [$this->main];
        }

        if (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {


        } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {


        } elseif (TypeIs::applyWith("boolean")->unfoldUsing($using) or
            TypeIs::applyWith("tuple")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                At::applyWith($this->main)
            )->unfold();

        } else {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                At::applyWith($this->main)
            )->unfold();

        }

        if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
            TypeIs::applyWith("tuple")->unfoldUsing($using)
        ) {
            $base = Shoop::pipe($using,
                TypeAsDictionary::apply(),
                At::applyWith($this->main)
            )->unfold();

            if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
                return $base;
            }

            return TypeAsTuple::apply()->unfoldUsing($base);


        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("array")->unfoldUsing($this->main)) {
                $using = $this->atFromList($using, $this->main);
                if (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
                    return $using;
                }
                return TypeAsArray::apply()->unfoldUsing($using);

            }
            return $this->atFromList($using, [$this->main]);

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
