<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpObject
};

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
