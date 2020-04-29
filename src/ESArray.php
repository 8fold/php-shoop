<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Split,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CompareImp,
    MathOperationsImp,
    ToggleImp,
    ShuffleImp,
    WrapImp,
    SortImp,
    HasImp
};

class ESArray implements
    Shooped,
    Compare,
    MathOperations,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Split,
    Has
{
    use ShoopedImp, CompareImp, MathOperationsImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp;

    public function __construct($array = [])
    {
        if (is_a($array, ESArray::class)) {
            $array = $array->unfold();

        } elseif (! is_array($array)) {
            $array = [$array];

        }
        $this->value = $array;
    }

// - Type Juggling
// - PHP single-method interfaces
// - Manipulate
// - Wrap
    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $count = 0;
        foreach ($needle as $val) {
            $array = $this->unfold();
            if (isset($array[$count]) && $array[$count] !== $val) {
                return Shoop::bool(false);
            }
            $count++;
        }
        return Shoop::bool(true);
    }

    public function endsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESArray::class)->unfold();
        $needle = array_reverse($needle);

        $v = $this->unfold();
        $v = array_reverse($v);

        $count = 0;
        foreach ($needle as $eye) {
            if ($v[$count] !== $eye) {
                return Shoop::bool(false);
            }
            $count++;
        }
        return Shoop::bool(true);
    }

// - Math language
    public function divide($value = null)
    {
        $index = Type::sanitizeType($value, ESInt::class)->unfold();

        $left = array_slice($this->unfold(), 0, $index);
        $right = array_slice($this->unfold(), $index);

        return Shoop::array([$left, $right]);
    }

    public function split($splitter = 1, $splits = 2)
    {
        return $this->divide($splitter);
    }

// - Comparison
// - Getters
    public function get($member)
    {
        $member = Type::sanitizeType($member, ESInt::class)->unfold();
        if ($this->offsetExists($member)) {
            $m = $this[$member];
            return ((Type::isPhp($m))) ? Type::sanitizeType($m) : $m;
        }
        trigger_error("Undefined index or member.");
    }

    public function first()
    {
        $v = $this->unfold();
        if (empty($v) && $this->isEmpty()) {
            return Shoop::array([]);
        }
        $v = $v[0];
        return Type::sanitizeType($v);
    }

    public function last()
    {
        $v = $this->unfold();
        if (empty($v) && $this->isEmpty()) {
            return Shoop::array([]);
        }
        $index = count($v) - 1;
        $v = $v[$index];
        return Type::sanitizeType($v);
    }

// - Other
    public function set($value, $key, $overwrite = true)
    {
        $key = Type::sanitizeType($key, ESInt::class)->unfold();
        $overwrite = Type::sanitizeType($overwrite, ESBool::class)->unfold();

        $cast = (array) $this->value;
        if (! $overwrite && $this->hasMember($key)) {
            $currentValue = $cast[$key];
            if (is_array($currentValue)) {
                $currentValue[] = $value;

            } else {
                $currentValue = [$currentValue, $value];

            }

            $cast[$key] = $currentValue;
            return static::fold($cast);
        }
        $merged = array_merge($cast, [$key => $value]);
        return static::fold($merged);
    }

    // TODO: Promote to ShoopedImp, with custom for ESString
    public function hasMember($member): ESBool
    {
        $member = Type::sanitizeType($member, ESInt::class)->unfold();
        $offsetExists = $this->offsetExists($member);
        return Shoop::bool($offsetExists);
    }

    public function join($delimiter = ""): ESString
    {
        $delimiter = Type::sanitizeType($delimiter, ESString::class);
        return Shoop::string(implode($delimiter->unfold(), $this->unfold()));
    }

    public function insertAt($value, $int)
    {
        // TODO: Consider making plus an alias of this
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $value = Type::sanitizeType($value, ESArray::class)->unfold();

        $lhs = array_slice($this->unfold(), 0, $int);
        $rhs = array_slice($this->unfold(), $int);

        $merged = array_merge($lhs, $value, $rhs);
        return Shoop::array($merged)->array();
    }

    public function drop($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = $this->unfold();
        unset($array[$int]);
        return Shoop::array($array)->array();
    }

    public function dropFirst($length = 1): ESArray
    {
        $length = Type::sanitizeType($length, ESInt::class)->unfold();

        $array = $this->array()->unfold();
        for ($i = 0; $i < $length; $i++) {
            array_shift($array);
        }
        return Shoop::array($array)->array();
    }

    public function dropLast($length = 1): ESArray
    {
        $v = $this->unfold();
        for ($i = 0; $i < $length; $i++) {
            array_pop($v);
        }
        $v = array_values($v);
        return Shoop::array($v);
    }

    public function noEmpties(): ESArray
    {
        return Shoop::array(array_filter($this->unfold()))->array();
    }

    public function each(\Closure $closure): ESArray
    {
        $build = [];
        foreach ($this->value as $key => $value) {
            $consider = $closure($value, $key = "");
            if ($consider !== null) {
                $build[] = $consider;
            }
        }
        return Shoop::array($build);
    }

    public function summed()
    {
        $total = 0;
        foreach ($this->unfold() as $int) {
            $total += Type::sanitizeType($int, ESInt::class)->unfold();
        }
        return Shoop::int($total);
    }

//-> Getters
    // private function knownMethodFromUnknownName(string $name)
    // {
    //     $call = "";
    //     $start = strlen($name) - strlen("Unfolded");
    //     $isFolded = $this->methodNameContains("Unfolded", $name, $start);
    //     if ($isFolded) {
    //         $call = lcfirst(substr_replace($name, "", $start, strlen($name) - $start));
    //     }

    //     if (strlen($call) === 0) {
    //         $className = static::class;
    //         trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);
    //     }
    //     return $call;
    // }

    // private function methodNameContains(string $needle, string $haystack, int $start)
    // {
    //     $needle = $needle;
    //     $end = strlen($haystack);
    //     $len = strlen($needle);
    //     return substr($haystack, $start, $len) === $needle;
    // }
}
