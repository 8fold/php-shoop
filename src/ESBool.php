<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    Toggle
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    ToggleImp
};

class ESBool implements Shooped, Compare, Toggle
{
    use ShoopedImp, CompareImp, ToggleImp;

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
// - PHP single-method interfaces
// - Manipulate
// - Math language
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

// -> Array Access
}
