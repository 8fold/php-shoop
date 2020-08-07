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
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    ToggleImp,
    IsInImp,
    EachImp
};

use Eightfold\Shoop\{
    ESString,
    ESJson
};

class ESInt implements Shooped, MathOperations, Toggle, IsIn, Each
{
    use ShoopedImp, MathOperationsImp, ToggleImp, IsInImp, EachImp;

    static public function to(ESInt $instance, string $className)
    {
        if ($className === ESArray::class) {
            return PhpInt::toIndexedArray($instance->main());

        } elseif ($className === ESBool::class) {
            return PhpInt::toBool($instance->main());

        } elseif ($className === ESDictionary::class) {
            return PhpInt::toAssociativeArray($instance->main());

        } elseif ($className === ESInt::class) {
            return $instance->main();

        } elseif ($className === ESJson::class) {
            return PhpInt::toJson($instance->main());

        } elseif ($className === ESObject::class) {
            return PhpInt::toObject($instance->main());

        } elseif ($className === ESString::class) {
            return PhpInt::toString($instance->main());

        }
    }

    static public function processedMain($main): int
    {
        if (is_int($main)) {
            $main = $main;

        } elseif (is_string($main)) {
            $main = intval($main);

        } elseif (is_a($main, ESInt::class)) {
            $main = $main->unfold();

        } elseif (is_float($main) || is_double($main)) {
            $main = round($main);

        } else {
            $main = 0;

        }
        return $main;
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
        $value = $this->main();
        return $value/$divisor;
    }

    public function max(...$comparisons)
    {
        return Shoop::array($comparisons)->plus($this->main())->each(function($int) {
            return Type::sanitizeType($int, ESInt::class);
        })->sort(false)->first();
    }

    public function min(...$comparisons)
    {
        return Shoop::array($comparisons)->plus($this->main())->each(function($int) {
            return Type::sanitizeType($int, ESInt::class);
        })->sort()->first();
    }

    public function isEven(\Closure $closure = null)
    {
        return $this->condition(PhpInt::isEven($this->main()), $closure);
    }

    public function isOdd(\Closure $closure = null)
    {
        return $this->condition(PhpInt::isOdd($this->main()), $closure);
    }
}
