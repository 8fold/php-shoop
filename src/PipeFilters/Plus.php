<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class Plus extends Filter
{
    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                Plus::applyWith($this->main),
                TypeAsBoolean::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];
            }

            $int = array_sum($this->main);
            return $using + $int;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (! is_array($this->main)) {
                $this->main = [$this->main];

            } elseif (TypeIs::applyWith("array")->unfoldUsing($using)) {
                $this->main = array_values($this->main);

            }

            return array_merge($using, $this->main);

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

    static private function fromString(
        string $using,
        string $characters = "",
        bool $prepend = false
    ): string
    {
        return ($prepend) ? $characters . $using : $using . $characters;
    }
}
