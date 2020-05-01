<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Toggle,
    Compare
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    CompareImp
};

use Eightfold\Shoop\{
    ESString,
    ESJson
};

use Eightfold\Shoop\Helpers\Type;


class ESInt implements Shooped, MathOperations, Toggle
{
    use ShoopedImp, MathOperationsImp, ToggleImp, CompareImp;

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
// - Search
// - Math language
// - Getters
// - Comparison
// - Other
    public function set($value)
    {
        $value = Type::sanitizeType($value, ESInt::class)->unfold();
        return self::fold($value);
    }

    public function range($int = 0)
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
