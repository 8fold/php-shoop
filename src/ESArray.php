<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Countable,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Split,
    Has
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CountableImp,
    ToggleImp,
    ShuffleImp,
    WrapImp,
    SortImp,
    HasImp
};

class ESArray implements
    Shooped,
    Countable,
    Toggle,
    Shuffle,
    Wrap,
    Sort,
    Split,
    Has
{
    use ShoopedImp, CountableImp, ToggleImp, ShuffleImp, WrapImp, SortImp, HasImp;

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
    public function string(): ESString
    {
        $printed = print_r($this->unfold(), true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        return Shoop::string($commas);
    }

    public function array(): ESArray
    {
        $v = $this->unfold();
        $v = array_values($v);
        return Shoop::array($v);
    }

    public function dictionary(): ESDictionary
    {
        $build = [];
        foreach ($this->value as $key => $value) {
            $key = "i". $key;
            $build[$key] = $value;
        }
        return Shoop::dictionary($build);
    }

    public function json(): ESJson
    {
        $obj = $this->object();
        return Shoop::json(json_encode($obj->unfold()));
    }

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
    public function plus(...$args)
    {
        $count = count($args);
        switch ($count) {
            case 0:
                return Shoop::array($this->unfold());
                break;

            case 1:
                $args = Type::sanitizeType($args[0], ESArray::class)->unfold();
                $merged = array_merge($this->unfold(), $args);
                return Shoop::array($merged);
                break;

            default:
                $merged = array_merge($this->unfold(), $args);
                return Shoop::array($merged);
                break;
        }
    }

    public function minus(...$args): ESArray
    {
        if (Type::isNotArray($args)) {
            $args = [$args];
        }
        $deletes = Type::sanitizeType($args, ESArray::class)->unfold();
        $copy = $this->unfold();
        $array = array_filter($copy, function($value) use ($deletes) {
          return ! in_array($value, $deletes);
        });
        return Shoop::array(array_values($array));
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $catch = null;
        for ($i = 0; $i < $int; $i++) {
            if ($catch === null) {
                $catch = $this->plus(...$this->unfold());

            } else {
                $catch = $catch->plus(...$this->unfold());

            }
        }
        return $catch;
    }

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
        trigger_error("Undefined index or memember.");
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
    // TODO: Promote to ShoopedImp, with custom for ESString
    public function hasMember($member): ESBool
    {
        $member = Type::sanitizeType($member, ESInt::class)->unfold();
        return Shoop::bool($this->offsetExists($member));
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

//-> Getters
    // public function __call(string $name, array $args = [])
    // {
    //     $call = $this->knownMethodFromUnknownName($name);
    //     $result = $this->{$call}(...$args);
    //     if (Type::isShooped($result)) {
    //         return $result->unfold();
    //     }
    //     return $result;
    // }

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

// -> Array Access
    // public function offsetExists($offset): bool {}

    // public function offsetGet($offset) {}

    // public function offsetSet($offset, $value): void {}

    // public function offsetUnset($offset): void {}
    // public function offsetExists($offset): bool
    // {
    //     return isset($this->value[$offset]);
    // }

    // public function offsetGet($offset)
    // {
    //     return ($this->offsetExists($offset))
    //         ? $this->value[$offset]
    //         : null;
    // }

    // public function offsetSet($offset, $value)
    // {
    //     $stash = $this->value;
    //     if (is_null($offset)) {
    //         $stash = $value;

    //     } else {
    //         $stash[$offset] = $value;

    //     }
    //     return static::fold($stash);
    // }

    // public function offsetUnset($offset)
    // {
    //     $stash = $this->value;
    //     unset($stash[$offset]);
    //     return static::fold($stash);
    // }

// //-> Iterator
    // public function current()
    // {
    //     $current = key($this->value);
    //     return $this->value[$current];
    // }

    // public function key()
    // {
    //     return key($this->value);
    // }

    // public function next()
    // {
    //     next($this->value);
    //     return $this;
    // }

    // public function rewind()
    // {
    //     reset($this->value);
    //     return $this;
    // }

    // public function valid(): bool
    // {
    //     $key = key($this->value);
    //     $var = ($key !== null && $key !== false);
    //     return $var;
    // }
}
