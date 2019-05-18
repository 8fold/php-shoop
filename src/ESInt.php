<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESTypeMap,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    ComparableImp
};

class ESInt extends ESBaseType
{
    use ComparableImp;

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
		return ESInt::wrap((int) floor($enumerator/$divisor));
	}

    public function isFactorOf($int): ESBool
    {
        return ESBool::wrap($this->remainder($int)->unwrap() == 0);
    }

	public function remainder($divisor): ESInt
	{
        $divisor = $this->sanitizeTypeOrTriggerError($divisor, "integer");
		return ESInt::wrap($this->unwrap() % $divisor->unwrap());
	}
}
