<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Sort,
    Wrap,
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
    SortImp,
    WrapImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

use Eightfold\Shoop\ESInt;

class ESDictionary implements
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Sort,
    Wrap,
    Drop,
    Has,
    IsIn,
    Each
{
    use ShoopedImp, CompareImp, MathOperationsImp, ToggleImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

    public function __construct($dictionary)
    {
        if (is_array($dictionary) && Type::isDictionary($dictionary)) {
            $this->value = $dictionary;

        } elseif (is_a($dictionary, ESDictionary::class)) {
            $this->value = $dictionary->unfold();

        } else {
            $this->value = [];

        }
    }

    // public function each(\Closure $closure): ESArray
    // {
    //     $items = $this->value();
    //     $array = array_map($closure, array_values($items), array_keys($items));
    //     return Shoop::this($array);
    // }
}
