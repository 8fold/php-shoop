<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpObject
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
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
    MathOperationsImp,
    SortImp,
    ToggleImp,
    WrapImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

class ESObject implements Shooped, MathOperations, Sort, Toggle, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp, MathOperationsImp, SortImp, ToggleImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;

    static public function to(ESObject $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpObject::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return PhpObject::toBool($instance->value());

        } elseif ($className === ESDictionary::class) {
            return PhpObject::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return PhpObject::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return PhpObject::toJson($instance->value());

        } elseif ($className === ESObject::class) {
            return $instance->value();

        } elseif ($className === ESString::class) {
            return PhpObject::toString($instance->value());

        }
    }

    static public function processedMain($main)
    {
        if (is_object($main)) {
            $main = $main;

        } elseif (is_a($main, ESObject::class)) {
            $main = $main->unfold();

        } elseif (Type::is($main, ESArray::class, ESDictionary::class)) {
            $main = (object) $main->unfold();

        } elseif (is_array($main)) {
            $main = (object) $main;

        } else {
            $main = new \stdClass();

        }
        return $main;
    }
}
