<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpAssociativeArray
};

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

    static public function to(ESDictionary $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpAssociativeArray::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return PhpAssociativeArray::toBool($instance->value());;

        } elseif ($className === ESDictionary::class) {
            return $instance->value();

        } elseif ($className === ESInt::class) {
            return PhpAssociativeArray::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return PhpAssociativeArray::toJson($instance->value());

        } elseif ($className === ESObject::class) {
            return PhpAssociativeArray::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return PhpAssociativeArray::toString($instance->value());

        }
    }

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
}
