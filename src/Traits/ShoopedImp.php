<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESArray,
    ESBool,
    ESInt,
    ESString,
    ESObject,
    ESJson,
    ESDictionary
};

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Helpers\Type;

trait ShoopedImp
{
    protected $value;

    protected $dictionary;

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
    public function string(): ESString
    {
        $printed = print_r($this->unfold(), true);
        $oneLine = preg_replace('/\s+/', ' ', $printed);
        $commas = str_replace(
            [" [", " ) ", " (, "],
            [", [", ")", "("],
            $oneLine);
        $fixSpacingWhenEmpty = preg_replace('/\s+\(/', "(", $commas, 1);
        return Shoop::string(trim($fixSpacingWhenEmpty));
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

// - Manipulating
// - Math language
    public function multiply($int = 1)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $array = [];
        for ($i = 0; $i < $int; $i++) {
            $array[] = $this;
        }
        return Shoop::array($array);
    }

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
        // die(var_dump(Type::isEmpty($this)));
        return Shoop::bool(Type::isEmpty($this));
    }

// - Setters/Getters
// - Callers
    public function __call($name, $args = [])
    {
        $startsWithSet = substr($name, 0, strlen("set")) === "set";
        $startsWithGet = substr($name, 0, strlen("get")) === "get";
        $endsWithUnfolded = substr($name, -(strlen("Unfolded"))) === "Unfolded";
        $name = Shoop::string($name)->unfold();
        if ($name === "getUnfolded") {
            $name = str_replace("Unfolded", "", $name);
            return $this->handleGetUnfolded($name, $args);

        } elseif ($startsWithSet) {
            $name = lcfirst(str_replace("set", "", $name));
            return $this->handleSet($name, $args);

        } elseif ($startsWithGet) {
            $name = lcfirst(str_replace("get", "", $name));
            return $this->get($name, $args);

        } elseif ($endsWithUnfolded) {
            $name = str_replace("Unfolded", "", $name);
            $value = $this->{$name}(...$args);
            return (Type::isShooped($value))
                ? $value->unfold()
                : $value;

        }

        $value = $this->get($name);
        $return = (isset($value) && Type::isShooped($value))
            ? $value->unfold()
            : $value;
        return $return;
    }

    private function handleSet($name, $args)
    {
        $name = lcfirst(str_replace("set", "", $name));
        $overwrite = (isset($args[1])) ? $args[1] : true;
        $value = (isset($args[0])) ? $args[0] : null;

        return $this->set($value, $name, $overwrite);
    }

    private function handleGetUnfolded($name, $args)
    {
        $value;
        if (! method_exists($this, $name)) {
            $className = static::class;
            trigger_error("{$name} is an invalid method on {$className}", E_USER_ERROR);

        } elseif ($name === "plus" || $name === "minus") {
            $value = $this->{$name}(...$args);

        } else {
            $value = $this->{$name}($args[0]);

        }
        return (Type::isShooped($value)) ? $value->unfold() : $value;
    }

// - PHP single-method interfaces
    public function __toString()
    {
        return $this->string()->unfold();
    }

// -> Array Access
    public function offsetExists($offset): bool
    {
        $v = $this->unfold();
        if (is_a($v, \stdClass::class)) {
            $v = (array) $v;
        }
        return isset($v[$offset]);
    }

    public function offsetGet($offset)
    {
        $v = (array) $this->unfold();
        if (array_key_exists($offset, $v)) {
            return $v[$offset];
        }
        // TODO: Replace with something else.
        // Undefined offset: 2
        return null;
    }

    public function offsetSet($offset, $value): void
    {
        $v = $this->unfold();
        if (is_a($v, \stdClass::class)) {
            $v = (array) $v;
        }
        $v[$offset] = $value;
        $this->value = $v;
    }

    public function offsetUnset($offset): void
    {
        $v = $this->unfold();
        if (is_a($v, \stdClass::class)) {
            $v = (array) $v;
        }
        unset($v[$offset]);
        $this->value = $v;
    }

//-> Iterator
    private $temp;

    /**
     * rewind() -> valid() -> current() -> key() -> next() -> valid()...repeat
     *
     * Same implementation for Object, Dictionary, JSON
     *
     * @return [type] [description]
     */
    public function rewind(): void
    {
        if (Type::is($this, ESObject::class, ESDictionary::class, ESJson::class)) {
            $this->temp = $this->dictionary()->unfold();

        } else {
            $this->temp = $this->array()->unfold();

        }
    }

    public function valid(): bool
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        return array_key_exists(key($this->temp), $this->temp);
    }

    public function current()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $key = key($temp);
        return $temp[$key];
    }

    public function key()
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        $temp = $this->temp;
        $key = key($temp);
        if (is_int($key)) {
            return Type::sanitizeType($key, ESInt::class, "int")->unfold();
        }
        return Type::sanitizeType($key, ESString::class, "string")->unfold();
    }

    public function next(): void
    {
        if (! isset($this->temp)) {
            $this->rewind();
        }
        next($this->temp);
    }
}
