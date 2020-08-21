<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class At extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            if (TypeIs::applyWith("integer")->unfoldUsing($this->main)) {
                return Shoop::pipe($using,
                    TypeAsArray::apply(),
                    At::applyWith($this->main),
                )->unfold();

            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                At::applyWith($this->main)
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                TypeAsArray::apply(),
                At::applyWith($this->main)
            )->unfold();

            $using = Shoop::pipe($using,
                TypeAsInteger::apply(),
                TypeAsArray::apply(),
                At::applyWith($this->main)
            )->unfold();
            if (is_array($using) and
                TypeAsInteger::apply()->unfoldUsing($this->main) > 1
            ) {
                return TypeAsArray::apply()->unfoldUsing($using);

            }
            return $using;

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                At::applyWith($this->main),
                TypeAsString::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("array")->unfoldUsing($this->main)) {
                $using = $this->atFromList($using, $this->main);
                if (TypeIs::applyWith("dictionary")->unfoldUsing($using)) {
                    return $using;
                }
                return TypeAsArray::apply()->unfoldUsing($using);

            }
            return $this->atFromList($using, [$this->main]);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            $base = Shoop::pipe($using,
                TypeAsDictionary::apply(),
                At::applyWith($this->main)
            )->unfold();
            if (TypeIs::applyWith("array")->unfoldUsing($this->main)) {
                return TypeAsTuple::apply()->unfoldUsing($base);

            }
            return $base;

        } elseif (TypeIs::applyWith("json")->unfoldUsing($using)) {
            $base = Shoop::pipe($using,
                TypeAsDictionary::apply(),
                At::applyWith($this->main)
            )->unfold();
            if (TypeIs::applyWith("array")->unfoldUsing($this->main)) {
                return TypeAsJson::apply()->unfoldUsing($base);

            }
            return $base;

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                At::applyWith($this->main)
            )->unfold();
        }
    }

    static private function atFromList(array $using, array $members)
    {
        if (TypeAsInteger::apply()->unfoldUsing($members) === 1) {
            $member = $members[0];
            return (isset($using[$member])) ? $using[$member] : false;
        }
        $build = [];
        foreach ($members as $member) {
            if (isset($using[$member])) {
                $build[$member] = $using[$member];

            }
        }
        return $build;
    }
}
