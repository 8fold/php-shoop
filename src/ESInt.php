<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Countable,
    Toggle,
    Shuffle,
    Compare
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    CountableImp,
    ToggleImp,
    ShuffleImp,
    CompareImp
};

use Eightfold\Shoop\{
    ESString,
    ESJson
};

use Eightfold\Shoop\Helpers\Type;


class ESInt implements Shooped, Countable, Toggle, Shuffle
{
    use ShoopedImp, CountableImp, ToggleImp, ShuffleImp, CompareImp;

    public function __construct($int)
    {
        if (is_int($int)) {
            $this->value = $int;

        } elseif (is_string($int)) {
            $this->value = intval($int);

        } elseif (is_a($int, ESInt::class)) {
            $this->value = $int->unfold();

        } elseif (is_float($int) || is_double($int)) {
            $this->value = round($int);

        } else {
            $this->value = 0;

        }
    }

// - Type Juggling
    // public function int(): ESInt
    // {
    //     return ESInt::fold($this->unfold());
    // }

// - Manipulate
    public function toggle($preserveMembers = true): ESInt
    {
        return $this->multiply(-1);
    }

// - Search
// - Math language
    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return ESInt::fold($this->unfold() * $int);
    }

    public function plus(...$args)
    {
        $terms = $args;
        $terms = $args;
        $total = $this->value;
        foreach ($terms as $term) {
            $term = Type::sanitizeType($term, ESInt::class)
                ->unfold();
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

    public function divide($value = null)
    {
        if ($value === null) {
            return $this;
        }

        $divisor = Type::sanitizeType($value, ESInt::class)->unfold();
        $enumerator = $this->unfold();
        return ESInt::fold((int) floor($enumerator/$divisor));
    }

// - Getters
    public function get()
    {
        return $this;
        // $member = Type::sanitizeType($member, ESInt::class)->unfold();
        // if ($this->hasMember($member)) {
        //     $m = $this->value[$member];
        //     return ((Type::isPhp($m))) ? Type::sanitizeType($m) : $m;
        // }
        // trigger_error("Undefined index or memember.");
    }

// - Comparison
// - Other
    public function set($value)
    {
        $value = Type::sanitizeType($value, ESInt::class)->unfold();
        return self::fold($value);
    }

    public function range($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        $range = range($int, $this->unfold());
        if ($int > $this->unfold()) {
            $range = range($this->unfold(), $int);
        }
        return Shoop::array($range);
    }

// - Transforms
// - Callers
// -> Array Access
    public function offsetExists($offset): bool
    {
        $array = $this->array();
        return isset($array[$offset]);
    }

    public function offsetGet($offset)
    {
        $array = $this->array()->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->value = $value;
    }

    // public function offsetUnset($offset): void {}
}
