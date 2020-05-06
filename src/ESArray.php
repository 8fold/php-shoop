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
    IsIn
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
    IsInImp
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
    IsIn
{
    use ShoopedImp, CompareImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, DropImp, HasImp, IsInImp;

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
        $total = 0;
        foreach ($this->unfold() as $int) {
            $total += Type::sanitizeType($int, ESInt::class)->unfold();
        }
        return Shoop::int($total);
    }

    public function insertAt($value, $int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $value = Type::sanitizeType($value, ESArray::class)->unfold();
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

    public function each(\Closure $closure): ESArray
    {
        $build = [];
        foreach ($this->value as $key => $value) {
            $consider = $closure($value, $key = "");
            if ($consider !== null) {
                $build[] = $consider;
            }
        }
        return Shoop::array($build);
    }
}
