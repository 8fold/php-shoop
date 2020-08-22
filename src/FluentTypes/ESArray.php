<?php

namespace Eightfold\Shoop\FluentTypes;

use \Closure;

use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;
use Eightfold\Shoop\FluentTypes\Traits\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Typeable;
use Eightfold\Shoop\FluentTypes\Contracts\TypeableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Arrayable;
use Eightfold\Shoop\FluentTypes\Contracts\ArrayableImp;

class ESArray implements
    Shooped,
    Typeable,
    Comparable,
    Arrayable
    // MathOperations,
    // Toggle,
    // Shuffle,
    // Wrap,
    // Sort,
    // Drop,
    // Has,
    // IsIn,
    // Each
{
    use ShoopedImp, TypeableImp, ComparableImp, ArrayableImp;//, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, DropImp, HasImp, IsInImp, EachImp;

    // static public function processedMain($main): array
    // {
    //     if (is_a($main, ESArray::class)) {
    //         $main = $main->unfold();

    //     } elseif (! is_array($main)) {
    //         $main = [$main];

    //     }
    //     return $main;
    // }

    // // TODO: Can't make part of interface because of typing
    // static public function to(ESArray $instance, string $className)
    // {
    //     if ($className === ESArray::class) {
    //         return $instance->main();

    //     } elseif ($className === ESBoolean::class) {
    //         return PhpIndexedArray::toBool($instance->main());

    //     } elseif ($className === ESDictionary::class) {
    //         return PhpIndexedArray::toAssociativeArray($instance->main());

    //     } elseif ($className === ESInteger::class) {
    //         return PhpIndexedArray::toInt($instance->main());

    //     } elseif ($className === ESJson::class) {
    //         return PhpIndexedArray::toJson($instance->main());

    //     } elseif ($className === ESTuple::class) {
    //         return PhpIndexedArray::toObject($instance->main());

    //     } elseif ($className === ESString::class) {
    //         return PhpIndexedArray::toString($instance->main());

    //     }
    // }

    // TODO: PHP 8.0 string|ESString = $delimiter
    public function join($delimiter = ""): ESString
    {
        $delimiter = Type::sanitizeType($delimiter, ESString::class);
        return Shoop::string(implode($delimiter->unfold(), $this->unfold()));
    }

    public function sum(): ESInteger
    {
        $array = $this->unfold();
        $sum = array_sum($array);
        return Shoop::integer($sum);
    }

    // TODO: PHP 8.0 int|ESInteger
    public function random($limit = 1): ESArray
    {
        $limit = Type::sanitizeType($limit, ESInteger::fold($limit))->unfold();
        $array = $this->main();
        if (count($array) === 0) {
            return Shoop::array([]);
        }

        $members = array_rand($array, $limit);
        if ($limit === 1) {
            $members = [$members];
        }

        return Shoop::array($members)->each(function($member) use ($array) {
            return Shoop::this($array[$member]);
        });
    }

    // TODO: bool|ESBoolean
    public function filter(Closure $closure, $useValues = true, $useMembers = false): ESArray
    {
        $useValues  = Type::sanitizeType($useValues, ESBoolean::class);
        $useMembers = Type::sanitizeType($useMembers, ESBoolean::class);

        $flag = 0;
        if ($useValues and $useMembers) {
            $flag = ARRAY_FILTER_USE_BOTH;

        } elseif (! $useValues and $useMembers) {
            $flag = ARRAY_FILTER_USE_KEY;

        }
        $filtered = array_filter($this->main(), $closure, $flag);
        $array = array_values($filtered);
        return Shoop::array($array);
    }

    public function reindex(): ESArray
    {
        $array = $this->main();
        $reindexed = array_values($array);
        return Shoop::array($reindexed);
    }

    public function flatten(): ESArray
    {
        $array = $this->main();
        $a = Shoop::array([]);
        array_walk_recursive($array, function($value, $index) use (&$a) {
            $shooped = Shoop::this($value);
            $a = $a->plus($shooped);
        });
        return $a;
    }
}
