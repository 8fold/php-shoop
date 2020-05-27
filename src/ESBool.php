<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpBool
};

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    Toggle,
    IsIn
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    ToggleImp,
    IsInImp
};

class ESBool implements Shooped, Compare, Toggle, IsIn
{
    use ShoopedImp, CompareImp, ToggleImp, IsInImp;

    static public function to(ESBool $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpBool::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return $instance->value();

        } elseif ($className === ESDictionary::class) {
            return PhpBool::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return PhpBool::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return PhpBool::toJson($instance->value());

        } elseif ($className === ESObject::class) {
            return PhpBool::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return PhpBool::toString($instance->value());

        }
    }

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
}
