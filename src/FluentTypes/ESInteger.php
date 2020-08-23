<?php

namespace Eightfold\Shoop\FluentTypes;

use \Closure;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

use Eightfold\Shoop\FluentTypes\ESString;
use Eightfold\Shoop\FluentTypes\ESJson;

class ESInteger implements Shooped //, MathOperations, Toggle, IsIn, Each
{
    use ShoopedImp;//, MathOperationsImp, ToggleImp, IsInImp, EachImp;

    // static public function to(ESInteger $instance, string $className)
    // {
    //     if ($className === ESArray::class) {
    //         return PhpInt::toIndexedArray($instance->main());

    //     } elseif ($className === ESBoolean::class) {
    //         return PhpInt::toBool($instance->main());

    //     } elseif ($className === ESDictionary::class) {
    //         return PhpInt::toAssociativeArray($instance->main());

    //     } elseif ($className === ESInteger::class) {
    //         return $instance->main();

    //     } elseif ($className === ESJson::class) {
    //         return PhpInt::toJson($instance->main());

    //     } elseif ($className === ESTuple::class) {
    //         return PhpInt::toObject($instance->main());

    //     } elseif ($className === ESString::class) {
    //         return PhpInt::toString($instance->main());

    //     }
    // }

    static public function processedMain($main): int
    {
        if (is_int($main)) {
            $main = $main;

        } elseif (is_string($main)) {
            $main = intval($main);

        } elseif (is_a($main, ESInteger::class)) {
            $main = $main->unfold();

        } elseif (is_float($main) || is_double($main)) {
            $main = round($main);

        } else {
            $main = 0;

        }
        return $main;
    }

    // TODO: PHP 8.0 int|ESInteger
    public function range($int = 0): ESArray
    {
        $int = Type::sanitizeType($int, ESInteger::class)->unfold();
        $range = range($int, $this->unfold());
        if ($int > $this->unfold()) {
            $range = range($this->unfold(), $int);
        }
        return Shoop::array($range);
    }

    // TODO: PHP 8.0 float|int|ESInteger
    public function roundUp($divisor = 0): ESInteger
    {
        $result = $this->divideNatural($divisor);
        $int = (int) ceil($result);
        return Shoop::this($int);
    }

    // TODO: PHP 8.0 float|int|ESInteger
    public function roundDown($divisor = 0): ESInteger
    {
        $result = $this->divideNatural($divisor);
        $int = (int) floor($result);
        return Shoop::this($int);
    }

    // TODO: PHP 8.0 float|int|ESInteger
    private function divideNatural($divisor = 0): float
    {
        if (Type::isFoldable($divisor)) {
            $divisor = $divisor->unfold();
        }
        $value = $this->main();
        return $value/$divisor;
    }

    public function max(...$comparisons): ESInteger
    {
        return Shoop::array($comparisons)->plus($this->main())->each(function($int) {
            return Type::sanitizeType($int, ESInteger::class);
        })->sort(false)->first();
    }

    public function min(...$comparisons): ESInteger
    {
        return Shoop::array($comparisons)->plus($this->main())->each(function($int) {
            return Type::sanitizeType($int, ESInteger::class);
        })->sort()->first();
    }

    public function isEven(Closure $closure = null)
    {
        return $this->condition(PhpInt::isEven($this->main()), $closure);
    }

    public function isOdd(Closure $closure = null)
    {
        return $this->condition(PhpInt::isOdd($this->main()), $closure);
    }
}
