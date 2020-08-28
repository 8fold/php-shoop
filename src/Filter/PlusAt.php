<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class PlusAt extends Filter
{
    private $value;
    private $member    = "";
    private $overwrite = false;

    public function __construct(
        $value, // mixed
        $member = PHP_INT_MAX, // int|string
        bool $overwrite = false
    )
    {
        $this->value     = $value;
        $this->member    = $member;
        $this->overwrite = $overwrite;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using)) {
            return Plus::applyWith($this->value)->unfoldUsing($using);

        } elseif (TypeIs::applyWith("number")->unfoldUsing($using)) {
            return Plus::applyWith($this->value)->unfoldUsing($using);

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (! is_array($this->value)) {
                $this->value = [$this->value];
            }

            if (is_int($this->member) and $this->member === PHP_INT_MAX) {
                $using = Plus::applyWith($this->value)->unfoldUsing($using);

            } elseif (! $this->overwrite and is_int($this->member)) {
                $count  = TypeAsInteger::apply()->unfoldUsing($this->value);
                $using = Shoop::pipe($using,
                    From::applyWith($this->member, $count),
                    Plus::applyWith($this->value),
                    Plus::applyWith(
                        From::applyWith($count)->unfoldUsing($using)
                    )
                )->unfold();

            } elseif (! $this->overwrite and is_string($this->member) and ! isset($using[$this->member])) {
                $using[$this->member] = (count($this->value) === 1)
                    ? At::applyWith(0)->unfoldUsing($this->value)
                    : $this->value;
                return $using;

            } elseif ($this->overwrite and is_string($this->member) and isset($using[$this->member])) {
                $using[$this->member] = (count($this->value) === 1)
                    ? At::applyWith(0)->unfoldUsing($this->value)
                    : $this->value;
                return $using;

            } elseif ($this->overwrite and isset($using[$this->member])) {
                $using[$this->member] = (count($this->value) === 1)
                    ? At::applyWith(0)->unfoldUsing($this->value)
                    : $this->value;

            }
            return TypeAsArray::apply()->unfoldUsing($using);

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                PlusAt::applyWith($this->value, $this->member, $this->overwrite),
                TypeAsString::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                PlusAt::applyWith($this->value, $this->member, $this->overwrite),
                TypeAsTuple::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("object")->unfoldUsing($using)) {

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
