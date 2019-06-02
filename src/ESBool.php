<?php

namespace Eightfold\Shoop;

class ESBool extends ESBaseType
{
	public function toggle(): ESBool
	{
        return ESBool::wrap(! $this->unwrap());
	}

	public function not(): ESBool
	{
		return $this->toggle();
	}

	public function or($bool): ESBool
	{
        $bool = parent::sanitizeTypeOrTriggerError($bool, "boolean");
        return Shoop::bool($this->unwrap() || $bool->unwrap());
	}

	public function and($bool): ESBool
	{
        $bool = parent::sanitizeTypeOrTriggerError($bool, "boolean");
        return Shoop::bool($this->unwrap() && $bool->unwrap());
	}

	public function description(): ESString
	{
        return ($this->value)
            ? ESString::wrap("true")
            : ESString::wrap("false");
	}
}
