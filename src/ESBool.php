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

    public function json(): ESJson
    {
        return Shoop::json(json_encode($this->string()->unfold()));
    }

// - PHP single-method interfaces
// - Manipulate
    public function toggle($preserveMembers = true): ESBool
    {
        return ESBool::fold(! $this->unfold());
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
