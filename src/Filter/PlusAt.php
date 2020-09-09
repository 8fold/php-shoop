<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

class PlusAt extends Filter
{
    private $value;
    private $member    = "";

    public function __construct(
        $value, // mixed
        $member = PHP_INT_MAX
    )
    {
        if (is_a($value, Foldable::class)) {
            $value = $value->unfold();
        }
        $this->value = $value;

        if (is_a($member, Foldable::class)) {
            $member = $member->unfold();
        }
        $this->member = $member;
    }

    public function __invoke($using)
    {
        if (TypeIs::applyWith("boolean")->unfoldUsing($using) or
            TypeIs::applyWith("number")->unfoldUsing($using)
        ) {
            return Apply::plus($this->value)->unfoldUsing($using);

        } elseif (TypeIs::applyWith("list")->unfoldUsing($using)) {
            if (TypeIs::applyWith("dictionary")->unfoldUsing($using) and
                TypeIs::applyWith("integer")->unfoldUsing($this->member)
            ) {
                $this->member = Apply::prepend("i")->unfoldUsing($this->member);

            }

            $using[$this->member] = $this->value;

            if (TypeIs::applyWith("integer")->unfoldUsing($this->member)) {
                return array_values($using);

            }
            return $using;

        } elseif (TypeIs::applyWith("string")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsArray::apply(),
                PlusAt::applyWith($this->value, $this->member),
                TypeAsString::apply()
            )->unfold();

        } elseif (TypeIs::applyWith("tuple")->unfoldUsing($using)) {
            return Shoop::pipe($using,
                TypeAsDictionary::apply(),
                PlusAt::applyWith($this->value, $this->member),
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
