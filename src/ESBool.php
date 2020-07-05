<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpBool
};

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Toggle,
    IsIn
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    ToggleImp,
    IsInImp
};

class ESBool implements Shooped, Toggle, IsIn
{
    use ShoopedImp, ToggleImp, IsInImp;

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

    /**
     * @deprecated
     */
    public function or($bool): ESBool
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() || $bool->unfold());
    }

    /**
     * @deprecated
     */
    public function and($bool): ESBool
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() && $bool->unfold());
    }
}
