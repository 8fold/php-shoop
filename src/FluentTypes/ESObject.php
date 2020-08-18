<?php

namespace Eightfold\Shoop\FluentTypes;

use \stdClass;

use Eightfold\Shoop\FluentTypes\Helpers\{

    PhpObject
};

use Eightfold\Shoop\FluentTypes\Interfaces\{
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

use Eightfold\Shoop\FluentTypes\Traits\{
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
            return PhpObject::toIndexedArray($instance->main());

        } elseif ($className === ESBool::class) {
            return PhpObject::toBool($instance->main());

        } elseif ($className === ESDictionary::class) {
            return PhpObject::toAssociativeArray($instance->main());

        } elseif ($className === ESInt::class) {
            return PhpObject::toInt($instance->main());

        } elseif ($className === ESJson::class) {
            return PhpObject::toJson($instance->main());

        } elseif ($className === ESObject::class) {
            return $instance->main();

        } elseif ($className === ESString::class) {
            return PhpObject::toString($instance->main());

        }
    }

    static public function processedMain($main): stdClass
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
            $main = new stdClass();

        }
        return $main;
    }
}
