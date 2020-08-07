<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpAssociativeArray
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
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
    MathOperations,
    Toggle,
    Sort,
    Wrap,
    Drop,
    Has,
    IsIn,
    Each
{
    use ShoopedImp, MathOperationsImp, ToggleImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

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

    static public function processedMain($main)
    {
        if (is_array($main) && Type::isDictionary($main)) {
            $main = $main;

        } elseif (is_a($main, ESDictionary::class)) {
            $main = $main->unfold();

        } else {
            $main = [];

        }
        return $main;
    }

    public function interleave()
    {
        $build = [];
        foreach ($this->main as $member => $value) {
            $build[] = $value;
            $build[] = $member;
        }
        return Shoop::this($build);
    }
}
