<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Members extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
            TypeIs::applyWith("tuple")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Members::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using) or
            TypeIs::applyWith("string")->unfoldUsing($using)
        ) {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                Members::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            return array_keys($using);

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if (is_a($using, Associable::class)) {
                return Shoop::pipe($using->efToDictionary(),
                    Members::apply()
                )->unfold();
            }

            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Members::apply()
            )->unfold();

        }
    }

    static public function fromList(array $list): array
    {
        return array_keys($list);
    }
}
