<?php

namespace Eightfold\Shoop;

class ESInt
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

	public function negate(): ESInt
	{
		$this->int = -1 * $this->int;
		return $this;
	}

	public function description(): string
	{
		return (string) $this->int;
	}

	public function distance(int $to = 0): ESInt
	{
		if ($to > $this->int) {
			$this->int = $to - $this->int;

		} else {
			$this->int = -1 * ($this->int - $to);

		}
		return $this;
	}

	public function advanced(int $by = 0): ESInt
	{
		$this->int = $this->int + $by;
		return $this;
	}
}