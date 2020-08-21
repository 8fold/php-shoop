<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Minus extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                Minus::applyWith($this->main),
                TypeAsBoolean::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            $int = array_sum($this->main);
            return $using - $int;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            $filtered = array_filter($using, function($v, $k) {
                return ! in_array($v, $this->main, true);
            }, ARRAY_FILTER_USE_BOTH);

            if (TypeIs::applyWith("dictionary")->unfoldUsing($filtered)) {
                return $filtered;

            }
            return TypeAsArray::apply()->unfoldUsing($filtered);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $this->fromString($using, ...$this->args(true));

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Minus::applyWith($this->main),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                Minus::applyWith($this->main)
            )->unfold();

        }
    }
}
