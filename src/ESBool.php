<?php

namespace Eightfold\Shoop;

class ESBool extends ESBaseType
{
	public function toggle(): ESBool
	{
        return ESBool::fold(! $this->unfold());
	}

	public function not(): ESBool
	{
		return $this->toggle();
	}

	public function or($bool): ESBool
	{
        $bool = parent::sanitizeType($bool, "boolean", ESBool::class);
        return Shoop::bool($this->unfold() || $bool->unfold());
	}

	public function and($bool): ESBool
	{
        $bool = parent::sanitizeType($bool, "boolean", ESBool::class);
        return Shoop::bool($this->unfold() && $bool->unfold());
	}

	public function description(): ESString
	{
        return ($this->value)
            ? ESString::fold("true")
            : ESString::fold("false");
	}
}
