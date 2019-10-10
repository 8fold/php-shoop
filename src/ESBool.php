<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

class ESBool implements Shooped
{
    use ShoopedImp;

// TODO: Could be a stretch
    public function enumerate(): ESArray
    {
        $first = $this->value;
        $second = ! $first;
        return Shoop::array([$first, $second]);
    }

    public function plus(...$args)
    {
        // can be implemented
    }

    public function prepend(...$args) {}

    public function divide($value = null) {}

    public function isDivisible($value): ESBool {}

    public function minus($value) {}

    public function multiply($int) {}

    public function isGreaterThan($compare): ESBool
    {
        // TODO: rename cast()
        $compare = Type::sanitizeType($compare, ESBool::class)->unfold();
        return (integer) $this->value > (integer) $compare;
    }

    public function isGreaterThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESBool::class)->unfold();
        return $this->unfold() >= $compare;
    }

    public function isLessThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESBool::class)->unfold();
        return $this->unfold() < $compare;
    }

    public function isLessThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESBool::class)->unfold();
        return $this->unfold() <= $compare;
    }









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
        $bool = $this->sanitizeType($bool, ESBool::class);
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
