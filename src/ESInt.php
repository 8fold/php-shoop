<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

use Eightfold\Shoop\Interfaces\{
    Equatable,
    Comparable,
    Wrappable,
    EquatableImp
};

class ESInt implements Equatable, Comparable, Wrappable
{
    use EquatableImp;

	private $value = 0;

    static public function wrap(...$args): ESInt
    {
        $initial = (isset($args[0])) ? floor($args[0]) : 0;
        return new ESInt($initial);
    }

	public function __construct(int $int = 0)
	{
        $this->value = $int;
	}

    public function unwrap(): int
    {
        return $this->value;
    }

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

//-> Arithmetic
	public function plus(ESInt $int): ESInt
	{
		return ESInt::wrap($this->unwrap() + $int->unwrap());
	}

	public function minus(ESInt $int): ESInt
	{
		return ESInt::wrap($this->unwrap() - $int->unwrap());
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
