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
    // public function string(): ESString
    // {
    //     $string = (string) $this;
    //     return Shoop::string($string);
    // }

    public function array(): ESArray
    {
        $array = (array) $this->unfold();
        return Shoop::array($array);
    }

    public function dictionary(): ESDictionary
    {
        if (Type::is($this, ESDictionary::class, ESObject::class)) {
            $array = (array) $this->unfold();
            return Shoop::dictionary($array);
        }
        return $this->array()->dictionary();
    }

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
    public function count(): ESInt
    {
        return $this->int();
    }

    public function __toString()
    {
        return $this->string()->unfold();
    }

// - Manipulate
    public function toggle($preserveMembers = true) // 7.4 : self
    {
        $array = $this->arrayUnfolded();
        $reversed = array_reverse($array);
        return Shoop::array($reversed)->enumerate();
    }

    public function sort($caseSensitive = true)
    {
        $caseSensitive = Type::sanitizeType($caseSensitive, ESBool::class)->unfold();
        $array = $this->array()->unfold();
        if ($caseSensitive) {
            natsort($array);

        } else {
            natcasesort($array);

        }
        return Shoop::array(array_values($array));
    }

    public function shuffle()
    {
        $array = $this->array()->unfold();
        shuffle($array);
        return Shoop::array($array);
    }

    public function start(...$prefixes)
    {
        $prefixes = Type::sanitizeType($prefixes)->unfold();
        $merged = array_merge($prefixes, $this->unfold());
        return Shoop::array($merged);
    }

    public function end(...$suffixes) // 7.4 : self;
    {
        return $this->plus(...$suffixes);
    }

// - Search
    public function has($value): ESBool
    {
        $value = Type::sanitizeType($value)->unfold();
        $bool = in_array($value, $this->array()->unfold());
        return Shoop::bool($bool);
    }

    public function doesNotStartWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->unfold();
        return $this->startsWith($needle)->toggle();
    }

    public function doesNotEndWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->unfold();
        return $this->endsWith($needle)->toggle();
    }

// - Math language
    public function plus(...$args)
    {
        $terms = $args;
        $terms = $args;
        $total = $this->value;
        foreach ($terms as $term) {
            $term = Type::sanitizeType($term, ESInt::class)->unfold();
            $total += $term;
        }
        return Shoop::int($total);
    }

    public function minus(...$args): ESInt
    {
        $total = $this->unfold();
        foreach ($args as $term) {
            $term = Type::sanitizeType($term, ESInt::class)->unfold();
            $total -= $term;
        }
        return ESInt::fold($total);
    }

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return ESInt::fold($this->unfold() * $int);
    }

    public function divide($value = null)
    {
        if ($value === null) {
            return $this;
        }

        $divisor = Type::sanitizeType($value, ESInt::class)->unfold();
        $enumerator = $this->unfold();
        return ESInt::fold((int) floor($enumerator/$divisor));
    }

    public function split($splitter = 1, $splits = 2)
    {
        return $this->divide($splitter);
    }

// - Comparison
    public function is($compare): ESBool
    {
        if (Type::isNotShooped($compare)) {
            $compare = Type::sanitizeType($compare);
        }
        $bool = $this->unfold() === $compare->unfold();
        return Shoop::bool($bool);
    }

    public function isNot($compare): ESBool
    {
        return $this->isSame($compare)->toggle();
    }

    public function isEmpty(): ESBool
    {
        return Type::isEmpty($this);
    }

    public function isGreaterThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESInt::class)
            ->unfold();
        $result = $this->unfold() > $compare;
        return Shoop::bool($result);
    }

    public function isGreaterThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        $result = $this->unfold() >= $compare;
        return Shoop::bool($result);
    }

    public function isLessThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        $result = $this->unfold() < $compare;
        return Shoop::bool($result);
    }

    public function isLessThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        $result = $this->unfold() <= $compare;
        return Shoop::bool($result);
    }

    /**
     * @deprecated
     */
    public function isSame($compare): ESBool
    {
        return $this->is($compare);
    }

//-> Getters
    public function first()
    {
        $array = $this->array()->unfold();
        $value = array_shift($array);
        if ($value === null) {
            return Shoop::array([]);
        }
        return Type::sanitizeType($this[0])->unfold();
    }

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

//-> Iterator
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
