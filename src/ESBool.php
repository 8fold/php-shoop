<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;
use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

class ESBool implements Shooped
{
    use ShoopedImp;

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

    public function array($value=''): ESArray
    {
        return Shoop::array([$this->unfold()]);
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

    public function dictionary(): ESDictionary
    {
        // <input required> => <input required=required>
        if ($this->unfold() === true) {
            return Shoop::dictionary([
                "true" => true,
                "false" => false
            ]);
        }
        return Shoop::dictionary([
            "true" => false,
            "false" => true
        ]);
    }

    public function object(): ESObject
    {
        $object = (object) $this->dictionary()->unfold();
        return Shoop::object($object);
    }

    public function int(): ESInt
    {
        $int = (integer) $this->unfold();
        return Shoop::int($int);
    }

    public function divide($value = null)
    {
        return $this;
    }

    public function split($splitter, $splits = 2): ESArray
    {
        return Shoop::array([
            Shoop::bool(true),
            Shoop::bool(false)
        ]);
    }

    public function __toString()
    {
        if ($this->unfold() === true) {
            return "true";
        }
        return "";
    }

    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->string();
        return $this->string()->startsWith($needle);
    }

    public function endsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->string()->toggle();
        $reversed = $this->string()->toggle();
        return $reversed->startsWith($needle);
    }

    public function start(...$prefixes)
    {
        return Shoop::bool(true);
    }

    public function plus(...$args)
    {
        return Shoop::bool(false);
    }

    public function toggle(): ESBool
    {
        return ESBool::fold(! $this->unfold());
    }

    public function minus(...$args): ESBool
    {
        return $this->toggle();
    }

    public function not(): ESBool
    {
        return $this->toggle();
    }




// TODO: Could be a stretch




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





















	public function or($bool): ESBool
	{
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() || $bool->unfold());
	}

	public function and($bool): ESBool
	{
        $bool = Type::sanitizeType($bool, "boolean", ESBool::class);
        return Shoop::bool($this->unfold() && $bool->unfold());
	}

	public function description(): ESString
	{
        return ($this->value)
            ? ESString::fold("true")
            : ESString::fold("false");
	}
}
