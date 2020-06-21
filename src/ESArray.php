<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpIndexedArray
};

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Drop,
    Has,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    MathOperationsImp,
    ToggleImp,
    ShuffleImp,
    WrapImp,
    SortImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

class ESArray implements
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Drop,
    Has,
    IsIn,
    Each
{
    use ShoopedImp, CompareImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, DropImp, HasImp, IsInImp, EachImp;

    // TODO: Can't make part of interface because of typing
    static public function to(ESArray $instance, string $className)
    {
        if ($className === ESArray::class) {
            return $instance->value();

        } elseif ($className === ESBool::class) {
            return PhpIndexedArray::toBool($instance->value());

        } elseif ($className === ESDictionary::class) {
            return PhpIndexedArray::toAssociativeArray($instance->value());

        } elseif ($className === ESInt::class) {
            return PhpIndexedArray::toInt($instance->value());

        } elseif ($className === ESJson::class) {
            return PhpIndexedArray::toJson($instance->value());

        } elseif ($className === ESObject::class) {
            return PhpIndexedArray::toObject($instance->value());

        } elseif ($className === ESString::class) {
            return PhpIndexedArray::toString($instance->value());

        }
    }

    public function __construct($array = [])
    {
        if (is_a($array, ESArray::class)) {
            $array = $array->unfold();

        } elseif (! is_array($array)) {
            $array = [$array];

        }
        $this->value = $array;
    }

    public function join($delimiter = ""): ESString
    {
        $delimiter = Type::sanitizeType($delimiter, ESString::class);
        return Shoop::string(implode($delimiter->unfold(), $this->unfold()));
    }

    public function sum()
    {
        $array = $this->unfold();
        $sum = array_sum($array);
        return Shoop::int($sum);
    }

    public function random($limit = 1)
    {
        $array = $this->value();
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

    public function filter(\Closure $closure, $useValues = true, $useMembers = false)
    {
        $flag = 0;
        if ($useValues and $useMembers) {
            $flag = ARRAY_FILTER_USE_BOTH;

        } elseif (! $useValues and $useMembers) {
            $flag = ARRAY_FILTER_USE_KEY;

        }
        $filtered = array_filter($this->value(), $closure, $flag);
        $array = array_values($filtered);
        return Shoop::array($array);
    }

    public function reindex()
    {
        $array = $this->value();
        $reindexed = array_values($array);
        return Shoop::array($reindexed);
    }

    public function flatten()
    {
        $array = $this->value();
        $a = Shoop::array([]);
        array_walk_recursive($array, function($value, $index) use (&$a) {
            $shooped = Shoop::this($value);
            $a = $a->plus($shooped);
        });
        return $a;
    }
}
