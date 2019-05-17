<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Equatable,
    Comparable,
    Wrappable,
    EquatableImp
};

class ESInt extends ESBaseType implements Comparable, Wrappable
{
	public function isMultipleOf(ESInt $int): ESBool
	{
		return ESBool::wrap($this->remainder($int)->unwrap() == 0);
	}

	public function quotientAndRemainder(ESInt $divisor): ESTuple
	{
		return ESTuple::init([
			"quotient" => ESInt::wrap($this->quotient($divisor)->unwrap()),
			"remainder" => ESInt::wrap($this->remainder($divisor)->unwrap())
		]);
	}

	public function negate(): ESInt
	{
		return ESInt::wrap($this->product(ESInt::wrap(-1))->unwrap());
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

	public function product(ESInt $int): ESInt
	{
		return ESInt::wrap($this->unwrap() * $int->unwrap());
	}

	public function quotient(ESInt $divisor): ESInt
	{
		return ESInt::wrap(floor($this->unwrap()/$divisor->unwrap()));
	}

	public function remainder(ESInt $divisor): ESInt
	{
		return ESInt::wrap($this->unwrap() % $divisor->unwrap());
	}

//-> Comparable
    public function isLessThan(Comparable $compare, bool $orEqual = false): ESBool
    {
        if ($orEqual) {
            if ($this->isLessThan($compare)->bool()) {
                return $this->isLessThan($compare);
            }
            return $this->isSameAs($compare);
        }
        return ESBool::wrap($this->unwrap() < $compare->unwrap());
    }

    public function isGreaterThan(Comparable $compare): ESBool
    {
        return $this->isLessThan($compare, true)->toggle();
    }
}
