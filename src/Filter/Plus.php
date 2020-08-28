<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Foldable;
use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

// TODO: tests ??
class Plus extends Filter
{
    private $value;
    private $start = "";

    public function __construct($value, $start = "")
    {
        $this->value = $value;
        if (is_a($this->value, Foldable::class)) {
            $this->value = $this->value->unfold();
        }
        $this->start = $start;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsInteger::apply(),
                Plus::applyWith($this->value),
                TypeAsBoolean::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            if (! is_array($this->value)) {
                $this->value = [$this->value];
            }

            $int = array_sum($this->value);
            return $using + $int;

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (! TypeIs::applyWith("list")->unfoldUsing($this->value)) {
                $this->value = [$this->value];
            }

            return ($this->start === 0)
                ? array_merge($this->value, $using)
                : array_merge($using, $this->value);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using) and
            ! TypeIs::applyWith("json")->unfoldUsing($using)
        ) {
            return $this->fromString($using, $this->value);

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            if (TypeIs::applyWith("tuple")->unfoldUsing($this->value)) {
                return Shoop::pipe($using,
                    TypeAsDictionary::apply(),
                    Plus::applyWith(
                        TypeAsDictionary::apply()->unfoldUsing($this->value)
                    ),
                    TypeAsTuple::apply()
                )->unfold();

            } elseif (! is_array($this->value)) {
                $this->value = [$this->value];

            }

            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                Plus::applyWith(
                    TypeAsDictionary::apply()->unfoldUsing($this->value)
                ),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {
            if (! is_array($this->value)) {
                $this->value = [$this->value];
            }
            return Shoop::pipe($using,
                TypeAsTuple::apply(),
                Plus::applyWith($this->value)
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
