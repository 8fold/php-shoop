<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESBaseType,
    ESString,
    ESRange
};

class ESBool extends ESBaseType
{

//-> Random
	static public function random(): ESBool
	{
		return ESRange::wrap(1, 1000)->random()->isFactorOf(2);
	}

	public function __construct(bool $bool = true)
	{
		$this->value = $bool;
	}

//-> Transforming
	public function toggle(): ESBool
	{
        return ESBool::wrap(! $this->unwrap());
	}

	public function not(): ESBool
	{
		return $this->toggle();
	}

	public function or(ESBool $bool): ESBool
	{
		if ($this->unwrap() || $bool->unwrap()) {
			return ESBool::wrap();
		}
		return ESBool::wrap(false);
	}

	public function and(ESBool $bool): ESBool
	{
		if ($this->unwrap() && $bool->unwrap()) {
			return ESBool::wrap();
		}
		return ESBool::wrap(false);
	}


//-> Describing
	public function description(): ESString
	{
        return ($this->value)
            ? ESString::wrap("true")
            : ESString::wrap("false");
	}
}
