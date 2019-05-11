<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

use Eightfold\Shoop\Interfaces\{
    Equatable,
    Comparable
};

class ESInt implements Equatable, Comparable
{
	private $int = 0;

	static public function init(int $int = 0): ESInt
	{
		return new ESInt($int);
	}

	static public function fromFloat(float $float = 0.0): ESInt
	{
		$int = floor($float);
		return static::init($int);
	}

	static public function fromDouble(float $double = 0.0000000): ESInt
	{
		return static::fromFloat($double);
	}

	static public function fromString(string $string = "0"): ESInt
	{
		$int = (int) $string;
		return static::init($int);
	}

	public function __construct(int $int = 0)
	{
		$this->int = $int;
	}

	public function int(): int
	{
		return $this->int;
	}

	public function isMultipleOf(int $int): ESBool
	{
		return ESBool::init($this->remainder($int)->int() == 0);
	}

	public function quotientAndRemainder(int $divisor): ESTuple
	{
		return ESTuple::init([
			"quotient" => ESInt::init($this->quotient($divisor)->int()),
			"remainder" => ESInt::init($this->remainder($divisor)->int())
		]);
	}

	public function negate(): ESInt
	{
		return ESInt::init($this->product(-1)->int());
	}

	public function description(): string
	{
		return (string) $this->int;
	}

	public function distance(int $to = 0): ESInt
	{
		if ($to > $this->int) {
			return ESInt::init($to - $this->int);
		}
		return ESInt::init(-1 * ($this->int - $to));
	}

	public function advanced(int $by = 0): ESInt
	{
		return ESInt::init($this->int + $by);
	}

//-> Arithmetic
	public function sum(int $int): ESInt
	{
		return ESInt::init($this->int + $int);
	}

	public function difference(int $int): ESInt
	{
		return ESInt::init($this->int - $int);
	}

	public function product(int $int): ESInt
	{
		return ESInt::init($this->int * $int);
	}

	public function quotient(int $divisor): ESInt
	{
		return ESInt::init(floor($this->int()/$divisor));
	}

	public function remainder(int $divisor): ESInt
	{
		return ESInt::init($this->int() % $divisor);
	}

//-> Compare
    public function isSameAs(Equatable $int): ESBool
    {
        return ESBool::init($this->int() === $int->int());
    }

    public function isNotSameAs(Equatable $int): ESBool
    {
        return ESBool::init($this->int() !== $int->int());
    }

    public function isLessThan(Comparable $compare, bool $orEqual = false): ESBool
    {
        if ($orEqual) {
            if ($this->isLessThan($compare)->bool()) {
                return $this->isLessThan($compare);
            }
            return $this->isSameAs($compare);
        }
        return ESBool::init($this->int() < $compare->int());
    }

    public function isGreaterThan(Comparable $compare): ESBool
    {
        return $this->isLessThan($compare, true)->toggle();
    }
}
