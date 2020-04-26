<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Toggle,
    Shuffle,
    Compare
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    ToggleImp,
    ShuffleImp,
    CompareImp
};

class ESBool implements Shooped, Toggle, Shuffle, Compare
{
    use ShoopedImp, ToggleImp, ShuffleImp, CompareImp;

    public function __construct($bool)
    {
        if (is_bool($bool)) {
            $this->value = $bool;

        } elseif (is_a($bool, ESBool::class)) {
            $this->value = $bool->unfold();

        } else {
            $this->value = false;

        }
    }

// - Type Juggling
    public function string(): ESString
    {
        $string = ($this->unfold()) ? "true" : "";
        return ESString::fold($string);
    }

    public function int(): ESInt
    {
        $bool = ($this->unfold()) ? 1 : 0;
        return ESInt::fold($bool);
    }

    public function array(): ESArray
    {
        return Shoop::array([$this->unfold()]);
    }

    public function dictionary(): ESDictionary
    {
        return ($this->unfold() === true)
            ? Shoop::dictionary(["true" => true, "false" => false])
            : Shoop::dictionary(["true" => false, "false" => true]);
    }

    public function object(): ESObject
    {
        $object = (object) $this->dictionary()->unfold();
        return Shoop::object($object);
    }

    public function json(): ESJson
    {
        return Shoop::json(json_encode($this->string()->unfold()));
    }

// - PHP single-method interfaces
// - Manipulate
    public function toggle($preserveMembers = true): ESBool
    {
        return ESBool::fold(! $this->unfold());
    }

// - Math language
// - Getters
    public function get()
    {
        return $this;
    }

// - Comparison
// - Other
    public function set($value)
    {
        $value = Type::sanitizeType($value, ESBool::class)->unfold();
        return self::fold($value);
    }

    public function not(): ESBool
    {
        return $this->toggle();
    }

    public function or($bool): ESBool
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() || $bool->unfold());
    }

    public function and($bool): ESBool
    {
        $bool = Type::sanitizeType($bool, ESBool::class);
        return Shoop::bool($this->unfold() && $bool->unfold());
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

    public function offsetSet($offset, $value): void
    {
        $stash = $this->value;
        if (! is_null($offset)) {
            $this->value[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        $stash = $this->value;
        unset($stash[$offset]);
    }

// //-> Iterator
    public function current()
    {
        $current = key($this->value);
        return $this->value[$current];
    }

    public function key()
    {
        return key($this->value);
    }

    public function next(): void
    {
        next($this->value);
    }

    public function rewind(): void
    {
        reset($this->value);
    }

    public function valid(): bool
    {
        $key = key($this->value);
        $var = ($key !== null && $key !== false);
        return $var;
    }
}
