<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpInt
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Toggle,
    Compare,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    CompareImp,
    IsInImp,
    EachImp
};

use Eightfold\Shoop\{
    ESString,
    ESJson
};

class ESInt implements Shooped, MathOperations, Toggle, IsIn, Each
{
    use ShoopedImp, MathOperationsImp, ToggleImp, CompareImp, IsInImp, EachImp;

    static public function to(ESInt $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpInt::toIndexedArray($instance->value());

        } elseif ($className === ESBool::class) {
            return PhpInt::toBool($instance->value());

        } elseif ($className === ESDictionary::class) {
            return PhpInt::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return $instance->value();

        } elseif ($className === ESJson::class) {
            return PhpInt::toJson($instance->value());

        } elseif ($className === ESObject::class) {
            return PhpInt::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return PhpInt::toString($instance->value());

        }
    }

    public function __construct($int)
    {
        if (is_int($int)) {
            $this->value = $int;

        } elseif (is_string($int)) {
            $this->value = intval($int);

        } elseif (is_a($int, ESInt::class)) {
            $this->value = $int->unfold();

        } elseif (is_float($int) || is_double($int)) {
            $this->value = round($int);

        } else {
            $this->value = 0;

        }
    }

    public function range($int = 0)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $range = range($int, $this->unfold());
        if ($int > $this->unfold()) {
            $range = range($this->unfold(), $int);
        }
        return Shoop::array($range);
    }

    public function roundUp($divisor = 0)
    {
        $result = $this->divideNatural($divisor);
        $int = (int) ceil($result);
        return Shoop::this($int);
    }

    public function roundDown($divisor = 0)
    {
        $result = $this->divideNatural($divisor);
        $int = (int) floor($result);
        return Shoop::this($int);
    }

    private function divideNatural($divisor = 0)
    {
        $divisor = Type::sanitizeType($divisor, ESInt::class)->unfold();
        $value = $this->value();
        return $value/$divisor;
    }

    public function max(...$comparisons)
    {
        return Shoop::array($comparisons)->plus($this->value())->each(function($int) {
            return Type::sanitizeType($int, ESInt::class);
        })->sort(false)->first();
    }

    public function min(...$comparisons)
    {
        return Shoop::array($comparisons)->plus($this->value())->each(function($int) {
            return Type::sanitizeType($int, ESInt::class);
        })->sort()->first();
    }

    public function isEven(\Closure $closure = null)
    {
        return $this->condition(PhpInt::isEven($this->value()), $closure);
    }

    public function isOdd(\Closure $closure = null)
    {
        return $this->condition(PhpInt::isOdd($this->value()), $closure);
    }
}
