<?php

namespace Eightfold\Shoop;

class ESDictionary extends ESBasetype implements
    \ArrayAccess,
    \Iterator
{
    public function __construct(...$args)
    {
        if (Shoop::array(...$args)->count()->isFactorOf(2)->toggle()->unwrap()) {
            trigger_error(
                "ESDict expects an even number of arguments wherein zero and even arguments are members and odd arguments are values.",
                E_USER_ERROR
            );
        }

        $sanitizedKeys = [];
        $values = [];
        foreach ($args as $index => $value) {
            if ($index === 0 || $index % 2 === 0) {
                $sanitizedKeys[] = $this->sanitizeTypeOrTriggerError(
                    $value,
                    "string",
                    ESString::class
                )->unwrap();

            } else {
                $values[] = $value;

            }
        }
        $this->value = array_combine($sanitizedKeys, $values);
    }

    public function hasKey($key): ESBool
    {
        $key = $this->sanitizeTypeOrTriggerError($key, "string", ESString::class)->unwrap();
        return Shoop::bool($this->offsetExists($key));
    }

    public function valueForKey($key)
    {
        $key = $this->sanitizeTypeOrTriggerError($key, "string", ESString::class)->unwrap();
        return $this->offsetGet($key);
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
        return ESInt::wrap($this->value[$current]);
    }

    public function key(): ESInt
    {
        return ESInt::wrap(key($this->value));
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

    /**
     * @return bool Must be bool for sake of PHP
     */
    public function valid(): bool
    {
        $key = key($this->value);
        $var = ($key !== null && $key !== false);
        return $var;
    }
}
