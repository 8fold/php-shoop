<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Toggle,
    Shuffle,
    Compare
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    ToggleImp,
    ShuffleImp,
    CompareImp
};

class ESBool implements Shooped, Toggle, Shuffle, Compare
{
    use ShoopedImp, ToggleImp, ShuffleImp, CompareImp;

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

// - Type Juggling
    public function string(): ESString
    {
        $string = ($this->unfold()) ? "true" : "";
        return ESString::fold($string);
    }

    public function array(): ESArray
    {
        return Shoop::array([$this->unfold()]);
    }

    public function dictionary(): ESDictionary
    {
        return ($this->unfold() === true)
            ? Shoop::dictionary(["true" => true, "false" => false])
            : Shoop::dictionary(["true" => false, "false" => true]);
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

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

// - PHP single-method interfaces
    public function __toString()
    {
        return $this->string()->unfold();
    }

// - Manipulate
    public function toggle($preserveMembers = true): ESBool
    {
        return ESBool::fold(! $this->unfold());
    }

    public function shuffle()
    {
        $random = rand(0, 1000);
        $isEven = $random % 2 === 0;
        return ESBool::fold($isEven);
    }

    public function sort($caseSensitive = true): ESBool
    {
        return ESBool::fold($this->unfold());
    }

    public function start(...$prefixes)
    {
        return Shoop::bool(true);
    }

    public function end(...$suffixes)
    {
        return Shoop::bool(false);
    }

// - Search
    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->unfold();
        return $this->string()->startsWith($needle);
    }

    public function endsWith($needle): ESBool
    {
        if ($this->unfold()) {
            $needle = Type::sanitizeType($needle)->string()->toggle();
            $reversed = $this->string()->toggle();
            return $reversed->startsWith($needle);
        }
        return ESBool::fold(false);
    }

// - Math language
    public function multiply($int): ESArray
    {
        $range = Type::sanitizeType($int, ESInt::class)
            ->array()->dropLast()->unfold();
        $array = [];
        foreach ($range as $int) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

    public function plus(...$args): ESBool
    {
        return Shoop::bool(true);
    }

    public function minus(...$args): ESBool
    {
        return Shoop::bool(false);
    }

    public function divide($value = null)
    {
        return $this;
    }

    public function split($splitter = 1, $splits = 2): ESArray
    {
        return Shoop::array([
            Shoop::bool(true),
            Shoop::bool(false)
        ]);
    }

// - Getters
// - Comparison
// - Other
    public function not(): ESBool
    {
        return $this->toggle();
    }

    public function or($bool): ESBool
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() || $bool->unfold());
    }

    public function and($bool): ESBool
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() && $bool->unfold());
    }
}
