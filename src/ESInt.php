<?php

namespace Eightfold\Shoop;

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

	public function plus($int): ESInt
	{
        return ESInt::wrap($this->unwrap() + $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap());
	}

    public function multipliedBy($int): ESInt
    {
        return ESInt::wrap($this->unwrap() * $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap());
    }

	public function minus($int): ESInt
	{
		return ESInt::wrap($this->unwrap() - $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap());
	}

	public function dividedBy($int): ESInt
	{
        $enumerator = $this->unwrap();
        $divisor = $this->sanitizeTypeOrTriggerError($int, "integer")->unwrap();
		return ESInt::wrap((int) floor($enumerator/$divisor));
	}

    public function isFactorOf($int): ESBool
    {
        $int = $this->sanitizeTypeOrTriggerError($int, "integer");
        return Shoop::bool($this->unwrap() % $int->unwrap() == 0);
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
        $compare = $this->sanitizeTypeOrTriggerError($compare, "int", ESInt::class);
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
