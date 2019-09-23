<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\{
    Foldable,
    Convertable
};

class ESBool extends ESBaseType
{
    use Foldable, Convertable;

    public function __construct($bool)
    {
        if (is_bool($bool)) {
            $this->value = $bool;

        } elseif (is_a($bool, ESBool::class)) {
            $this->value = $bool->unfold();

        } else {
            $this->value = false;

        }
    }
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
        $bool = $this->sanitizeType($bool, "boolean", ESBool::class);
        return Shoop::bool($this->unfold() || $bool->unfold());
	}

	public function and($bool): ESBool
	{
        $bool = $this->sanitizeType($bool, "boolean", ESBool::class);
        return Shoop::bool($this->unfold() && $bool->unfold());
	}

	public function description(): ESString
	{
        return ($this->value)
            ? ESString::fold("true")
            : ESString::fold("false");
	}
}
