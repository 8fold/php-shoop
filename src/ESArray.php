<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Drop,
    Has,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    MathOperationsImp,
    ToggleImp,
    ShuffleImp,
    WrapImp,
    SortImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

class ESArray implements
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Drop,
    Has,
    IsIn,
    Each
{
    use ShoopedImp, CompareImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, DropImp, HasImp, IsInImp, EachImp;

    public function __construct($array = [])
    {
        if (is_a($array, ESArray::class)) {
            $array = $array->unfold();

        } elseif (! is_array($array)) {
            $array = [$array];

        }
        $this->value = $array;
    }

    public function join($delimiter = ""): ESString
    {
        $delimiter = Type::sanitizeType($delimiter, ESString::class);
        return Shoop::string(implode($delimiter->unfold(), $this->unfold()));
    }

    public function sum()
    {
        $array = $this->unfold();
        $sum = array_sum($array);
        return Shoop::int($sum);
    }

    public function insertAt($value, $int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $value = [Type::sanitizeType($value)->unfold()];
        $array = $this->splitAtUnfolded($int);
        $lhs = $array["lhs"];
        $rhs = $array["rhs"];

        $merged = array_merge($lhs, $value, $rhs);
        return Shoop::array($merged)->array();
    }

    private function splitAt($int = 0)
    {
        $lhs = array_slice($this->value(), 0, $int);
        $rhs = array_slice($this->value(), $int);
        return [
            "lhs" => $lhs,
            "rhs" => $rhs
        ];
    }
}
