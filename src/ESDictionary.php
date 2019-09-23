<?php

namespace Eightfold\Shoop;

class ESDictionary extends ESBasetype implements
    \ArrayAccess,
    \Iterator
{
    public function __construct($args)
    {
        if ($args === null) {
            $this->value = [];

        } elseif (static::isAssociativeArray($args)) {
            $this->value = $args;

        } else {
            trigger_error("ESDictionary must begin with PHP associative array.");

        }
    }

    public function enumerated()
    {
        return Shoop::array(array_values($this->value));
    }

    public function plus($key, $values)
    {
        $key = $this->sanitizeType($key, "string", ESString::class)
            ->unfold();
        $values = $this->sanitizeType($values, "array", ESArray::class)
            ->unfold();

        $dict = $this->unfold();
        $dict[$key] = $values;
        return Shoop::dictionary($dict);
    }

    private function validateCounts(array $args)
    {
        $keyCount = Shoop::array(array_keys($args))->count();
        $valueCount = Shoop::array(array_values($args))->count();
        if ($keyCount->isNot($valueCount)->unfold()) {
            trigger_error(
                "ESDictionary expects an even number of arguments. Using 0 index, 0 and even arguments are members (keys) while odd arguments are values. {$keyCount->unfold()} items were found.",
                E_USER_ERROR
            );
        }
    }

    public function hasKey($key): ESBool
    {
        $key = $this->sanitizeType($key, "string", ESString::class)->unfold();
        return Shoop::bool($this->offsetExists($key));
    }

    public function valueForKey($key)
    {
        $key = $this->sanitizeType($key, "string", ESString::class)->unfold();
        if (array_key_exists($key, $this->value)) {
            return $this->value[$key];
        }
        return null;
    }

//-> ArrayAccess
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->value[] = $value;
        } else {
            $this->value[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->value[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->value[$offset]);
    }

    public function offsetGet($offset) {
        return ($this->offsetExists($offset))
            ? $this->value[$offset]
            : null;
    }

//-> Iterator
    public function current(): ESInt
    {
        $current = key($this->value);
        return ESInt::fold($this->value[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::fold(key($this->value));
    }

    public function next(): ESDictionary
    {
        next($this->value);
        return $this;
    }

    public function rewind(): ESDictionary
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
