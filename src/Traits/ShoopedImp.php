<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESBool,
    ESInt,
    ESString,
    ESObject,
    ESArray,
    ESDictionary
};

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

trait ShoopedImp
{
    protected $value;

    static public function fold($args)
    {
        return new static($args);
    }

    public function unfold()
    {
        // Preserve Shoop internally: unfold($preserve = false)
        // only implement if needed; otherwise, we're good.
        $return = $this->value;
        if (Type::isArray($return) || Type::isDictionary($return)) {
            $array = $return;
            $return = [];
            foreach ($array as $key => $value) {
                // preserve if (! $preserve && Type::isShooped($value)) {
                if (Type::isShooped($value)) {
                    $value = $value->unfold();
                }
                $return[$key] = $value;
            }
        }
        return $return;
    }

// - Type Juggling
    // TODO: Verify these are being used by someone
    public function object(): ESObject
    {
        $object = (object) $this->unfold();
        return Shoop::object($object);
    }

    public function int(): ESInt
    {
        $count = count($this->arrayUnfolded());
        return Shoop::int($count);
    }

    public function bool(): ESBool
    {
        $bool = (bool) $this->unfold();
        return Shoop::bool($bool);
    }

// - PHP single-method interfaces
    public function __toString()
    {
        return $this->string()->unfold();
    }

// - Manipulateg
// - Math language
// - Comparison
    public function is($compare): ESBool
    {
        if (Type::isNotShooped($compare)) {
            $compare = Type::sanitizeType($compare, static::class);
        }
        $bool = $this->unfold() === $compare->unfold();
        return Shoop::bool($bool);
    }

    public function isNot($compare): ESBool
    {
        return $this->is($compare)->toggle();
    }

    public function isEmpty(): ESBool
    {
        return Shoop::bool(empty($this));
    }

//-> Getters
    public function __call(string $name, array $args = [])
    {
        $call = $this->knownMethodFromUnknownName($name);
        $result = $this->{$call}(...$args);
        if (Type::isShooped($result)) {
            return $result->unfold();
        }
        return $result;
    }

    private function knownMethodFromUnknownName(string $name)
    {
        $call = "";
        $start = strlen($name) - strlen("Unfolded");
        $isFolded = $this->methodNameContains("Unfolded", $name, $start);
        if ($isFolded) {
            $call = lcfirst(substr_replace($name, "", $start, strlen($name) - $start));
        }

        if (strlen($call) === 0) {
            $className = static::class;
            trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);
        }
        return $call;
    }

    private function methodNameContains(string $needle, string $haystack, int $start)
    {
        $needle = $needle;
        $end = strlen($haystack);
        $len = strlen($needle);
        return substr($haystack, $start, $len) === $needle;
    }

// -> Array Access
    public function offsetExists($offset): bool
    {
        return isset($this->value[$offset]);
    }

    public function offsetGet($offset)
    {
        return ($this->offsetExists($offset))
            ? $this->value[$offset]
            : null;
    }

    public function offsetSet($offset, $value)
    {
        $stash = $this->value;
        if (is_null($offset)) {
            $stash = $value;

        } else {
            $stash[$offset] = $value;

        }
        return static::fold($stash);
    }

    public function offsetUnset($offset)
    {
        $stash = $this->value;
        unset($stash[$offset]);
        return static::fold($stash);
    }

// //-> Iterator
    public function current()
    {
        $current = key($this->value);
        return ESInt::fold($this->value[$current]);
    }

    public function key()
    {
        return ESInt::fold(key($this->value));
    }

    public function next()
    {
        next($this->value);
        return $this;
    }

    public function rewind()
    {
        reset($this->value);
        return $this;
    }

    public function valid(): bool
    {
        $key = key($this->value);
        $var = ($key !== null && $key !== false);
        return $var;
    }
}
