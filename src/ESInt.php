<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Comparable,
    Wrappable
};

class ESInt extends ESBaseType implements Comparable, Wrappable
{
	public function isMultipleOf(ESInt $int): ESBool
	{
		return ESBool::wrap($this->remainder($int)->unwrap() == 0);
	}

// NumberTest: 56
	// public function quotientAndRemainder(ESInt $divisor): ESTuple
	// {
	// 	return ESTuple::wrap(
 //            "quotient",
 //            ESInt::wrap($this->dividedBy($divisor)->unwrap()),
	// 		"remainder",
 //            ESInt::wrap($this->remainder($divisor)->unwrap())
	// 	);
	// }

	public function negate(): ESInt
	{
		return ESInt::wrap($this->multipliedBy(ESInt::wrap(-1))->unwrap());
	}

	public function description(): string
	{
		return (string) $this->value;
	}

	public function distance(int $to = 0): ESInt
	{
		if ($to > $this->value) {
			return ESInt::wrap($to - $this->value);
		}
		return ESInt::wrap(-1 * ($this->value - $to));
	}

	public function advanced(int $by = 0): ESInt
	{
		return ESInt::wrap($this->value + $by);
	}

    public function toggle(): ESInt
    {
        return ESInt::wrap(-1 * $this->unwrap());
    }

//-> Arithmetic
	public function plus($int): ESInt
	{
        return ESInt::wrap($this->unwrap() + $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap());
	}

	public function minus($int): ESInt
	{
		return ESInt::wrap($this->unwrap() - $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap());
	}

	public function multipliedBy($int): ESInt
	{
        return ESInt::wrap($this->unwrap() * $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap());
	}

	public function dividedBy($int): ESInt
	{
        $enumerator = $this->unwrap();
        $divisor = $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap();
		return ESInt::wrap(floor($enumerator/$divisor));
	}

	public function remainder(ESInt $divisor): ESInt
	{
		return ESInt::wrap($this->unwrap() % $divisor->unwrap());
	}

//-> Comparable
    public function isGreaterThan($compare, $orEqualTo = false): ESBool
    {
        return $this->compare(true, $compare, $orEqualTo);
    }

    public function isLessThan($compare, $orEqualTo = false): ESBool
    {
        return $this->compare(false, $compare, $orEqualTo);
    }

    private function compare(bool $greaterThan, $compare, $orEqualTo = false): ESBool
    {
        // TODO: Consider moving to trait
        $compare = $this->sanitizeTypeOrTriggerError($compare, "integer")->unwrap();
        $orEqualTo = $this->sanitizeTypeOrTriggerError($orEqualTo, "boolean", ESBool::class)->unwrap();
        if ($greaterThan) {
            return ($orEqualTo)
                ? ESBool::wrap($this->unwrap() >= $compare)
                : ESBool::wrap($this->unwrap() > $compare);
        }
        return ($orEqualTo)
            ? ESBool::wrap($this->unwrap() <= $compare)
            : ESBool::wrap($this->unwrap() < $compare);
    }
}
