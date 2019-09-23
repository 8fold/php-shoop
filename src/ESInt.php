<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\Foldable;

class ESInt extends ESBaseType
{
    use Foldable;

    public function __construct($int)
    {
        if (is_int($int)) {
            $this->value = $int;

        } elseif (is_a($int, ESInt::class)) {
            $this->value = $int->unfold();

        } else {
            $this->value = 0;

        }
    }

    public function toggle(): ESInt
    {
        return $this->multipliedBy(-1);
    }

    public function enumerated(): ESArray
    {
        return Shoop::array(range(0, $this->value));
    }

	public function plus($values): ESInt
	{
        $values = $this->sanitizeType($values, "int", ESInt::class)
            ->unfold();
        return Shoop::int($this->unfold() + $values);
	}

    public function multipliedBy($int): ESInt
    {
        return ESInt::fold($this->unfold() * $this->sanitizeType($int, "int", ESInt::class)->unfold());
    }

	public function minus($int): ESInt
	{
		return ESInt::fold($this->unfold() - $this->sanitizeType($int, "int", ESInt::class)->unfold());
	}

	public function dividedBy($int): ESInt
	{
        $enumerator = $this->unfold();
        $divisor = $this->sanitizeType($int, "int", ESInt::class)->unfold();
		return ESInt::fold((int) floor($enumerator/$divisor));
	}

    public function isFactorOf($int): ESBool
    {
        $int = $this->sanitizeType($int, "int", ESInt::class);
        return Shoop::bool($this->unfold() % $int->unfold() == 0);
    }

    public function isGreaterThan($compare, $orEqualTo = false): ESBool
    {
        return $this->compare(true, $compare, $orEqualTo);
    }

    public function isNotGreaterThan($compare)
    {
        return $this->isLessThan($compare, true);
    }

    public function isLessThan($compare, $orEqualTo = false): ESBool
    {
        return $this->compare(false, $compare, $orEqualTo);
    }

    public function isNotLessThan($compare)
    {
        return $this->isGreaterThan($compare, true);
    }

    private function compare(bool $greaterThan, $compare, $orEqualTo = false): ESBool
    {
        $compare = $this->sanitizeType($compare, "int", ESInt::class);
        $orEqualTo = $this->sanitizeType(
            $orEqualTo,
            "boolean",
            ESBool::class
        )->unfold();
        if ($greaterThan && $orEqualTo) {
            return ESBool::fold($this->unfold() >= $compare->unfold());

        } elseif ($greaterThan) {
            return ESBool::fold($this->unfold() > $compare->unfold());

        } elseif ($orEqualTo) {
            return ESBool::fold($this->unfold() <= $compare->unfold());

        } else {
            return ESBool::fold($this->unfold() < $compare->unfold());

        }
    }
}
