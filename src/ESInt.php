<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Toggle,
    Compare,
    IsIn
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    CompareImp,
    IsInImp
};

use Eightfold\Shoop\{
    ESString,
    ESJson
};

use Eightfold\Shoop\Helpers\Type;


class ESInt implements Shooped, MathOperations, Toggle, IsIn
{
    use ShoopedImp, MathOperationsImp, ToggleImp, CompareImp, IsInImp;

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

    public function range($int = 0)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $range = range($int, $this->unfold());
        if ($int > $this->unfold()) {
            $range = range($this->unfold(), $int);
        }
        return Shoop::array($range);
    }
}
