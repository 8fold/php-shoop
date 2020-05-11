<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Sort,
    Toggle,
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
    SortImp,
    ToggleImp,
    WrapImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

class ESObject implements Shooped, Compare, MathOperations, Sort, Toggle, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp, CompareImp, MathOperationsImp, SortImp, ToggleImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

    public function __construct($object)
    {
        if (is_object($object)) {
            $this->value = $object;

        } elseif (is_a($object, ESObject::class)) {
            $this->value = $object->unfold();

        } elseif (Type::is($object, ESArray::class, ESDictionary::class)) {
            $this->value = (object) $object->unfold();

        } elseif (is_array($object)) {
            $this->value = (object) $object;

        } else {
            $this->value = new \stdClass();

        }
    }
}
