<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESTypeMap,
    ESBool
};

class ESInt extends ESBaseType
{
	public function description(): string
	{
		return (string) $this->value;
	}

    public function toggle(): ESInt
    {
        return $this->multipliedBy(-1);
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
        $compare = $this->sanitizeTypeOrTriggerError($compare, "int");
        $orEqualTo = $this->sanitizeTypeOrTriggerError(
            $orEqualTo,
            "boolean",
            ESBool::class
        )->unwrap();
        if ($greaterThan && $orEqualTo) {
            return ESBool::wrap($this->unwrap() >= $compare->unwrap());

        } elseif ($greaterThan) {
            return ESBool::wrap($this->unwrap() > $compare->unwrap());

        } elseif ($orEqualTo) {
            return ESBool::wrap($this->unwrap() <= $compare->unwrap());

        } else {
            return ESBool::wrap($this->unwrap() < $compare->unwrap());

        }
    }
}
