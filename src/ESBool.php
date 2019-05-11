<?php

namespace Eightfold\Shoop;

class ESBool
{
	private $value = true;

	static public function init(bool $bool = true): ESBool
	{
		return new ESBool($bool);
	}

//-> Random
	static public function random(): ESBool
	{
		$int = rand(1, 1000);
		return ESBool::init($int % 2 == 0);
	}

	public function __construct(bool $bool = true)
	{
		$this->value = $bool;
	}

	public function bool(): bool
	{
		return $this->value;
	}

//-> Comparing
	public function isSameAs(ESBool $compare): ESBool
	{
		return ESBool::init($this->bool() === $compare->bool());
	}

	public function isNotSameAs(ESBool $compare): ESBool
	{
		return ESBool::init($this->bool() !== $compare->bool());
	}

//-> Transforming
	public function toggle(): ESBool
	{
		$this->value = ! $this->value;
		return $this;
	}

	public function not(): ESBool
	{
		return $this->toggle();
	}

	public function or(ESBool $bool): ESBool
	{
		if ($this->bool() || $bool->bool()) {
			return ESBool::init();
		}
		return ESBool::init(false);
	}

	public function and(ESBool $bool): ESBool
	{
		if ($this->bool() && $bool->bool()) {
			return ESBool::init();
		}
		return ESBool::init(false);
	}


//-> Describing
	/**
	 * TODO: return String class - no literal
	 * @return [type] [description]
	 */
	public function description(): string
	{
		return ($this->value) ? "true" : "false";
	}
}
