<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Toggle,
    Shuffle,
    Compare
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    ShuffleImp,
    CompareImp
};

use Eightfold\Shoop\{
    ESString,
    ESJson
};

use Eightfold\Shoop\Helpers\Type;


class ESInt implements Shooped, MathOperations, Toggle, Shuffle
{
    use ShoopedImp, MathOperationsImp, ToggleImp, ShuffleImp, CompareImp;

    public function __construct($int)
    {
        if (is_int($int)) {
            $this->value = $int;

        } elseif (is_string($int)) {
            $this->value = intval($int);

        } elseif (is_a($int, ESInt::class)) {
            $this->value = $int->unfold();

        } elseif (is_float($int) || is_double($int)) {
            $this->value = round($int);

        } else {
            $this->value = 0;

        }
    }

// - Type Juggling
// - Manipulate
    public function toggle($preserveMembers = true): ESInt
    {
        return $this->multiply(-1);
    }

// - Search
// - Math language
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return ESInt::fold($this->unfold() * $int);
    }

    public function divide($value = null)
    {
        if ($value === null) {
            return $this;
        }

        $divisor = Type::sanitizeType($value, ESInt::class)->unfold();
        $enumerator = $this->unfold();
        return ESInt::fold((int) floor($enumerator/$divisor));
    }

// - Getters
    public function get()
    {
        return $this;
        // $member = Type::sanitizeType($member, ESInt::class)->unfold();
        // if ($this->hasMember($member)) {
        //     $m = $this->value[$member];
        //     return ((Type::isPhp($m))) ? Type::sanitizeType($m) : $m;
        // }
        // trigger_error("Undefined index or memember.");
    }

// - Comparison
// - Other
    public function set($value)
    {
        $value = Type::sanitizeType($value, ESInt::class)->unfold();
        return self::fold($value);
    }

    public function range($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $range = range($int, $this->unfold());
        if ($int > $this->unfold()) {
            $range = range($this->unfold(), $int);
        }
        return Shoop::array($range);
    }

// - Transforms
// - Callers
// -> Array Access
}
