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
    public function string(): ESString
    {
        return Shoop::string((string) $this->unfold());
    }

    public function array(): ESArray
    {
        return Shoop::array($this->range(0));
    }

    public function dictionary(): ESDictionary
    {
        return $this->array()->dictionary();
    }

    public function int(): ESInt
    {
        return ESInt::fold($this->unfold());
    }

    public function json(): ESJson
    {
        return Shoop::object((object) ["json" => $this->unfold()])->json();
    }

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
        if ($int > $this->unfold()) {
            return Shoop::this(range($this->unfold(), $int));
        }
        return Shoop::this(range($int, $this->unfold()), ESArray::class);
    }

// - Transforms
// - Callers
    // public function __call($name, $args = [])
    // {
    //     $name = Shoop::string($name)->unfold();
    //     $startsWithSet = substr($name, 0, strlen("set")) === "set";
    //     $endsWithUnfolded = substr($name, -(strlen("Unfolded"))) === "Unfolded";
    //     if ($startsWithSet) {
    //         dump("starts with set");
    //         $member = lcfirst(str_replace("set", "", $name));
    //         $overwrite = (isset($args[1])) ? $args[1] : true;
    //         $value = (isset($args[0])) ? $args[0] : null;

    //         return $this->set($member, $value, $overwrite);

    //     } elseif ($endsWithUnfolded) {
    //         $name = str_replace("Unfolded", "", $name);
    //         if (! method_exists($this, $name)) {
    //             $className = static::class;
    //             trigger_error("{$member} is an invalid method on {$className}", E_USER_ERROR);

    //         } else {
    //             $value = $this->{$name}($args);
    //             if (Type::isShooped($value)) {
    //                 return $value->unfold();
    //             }
    //         }
    //         $value = $this->get($member);
    //         $return = (isset($value) && Type::isShooped($value))
    //             ? $value->unfold()
    //             : $value;
    //         return $return;

    //     } else {
    //         $name = lcfirst(str_replace("get", "", $name));
    //         return Type::sanitizeType($name);

    //     }
    // }

// -> Array Access
    public function offsetExists($offset): bool {}

    public function offsetGet($offset) {}

    public function offsetSet($offset, $value): void {}

    public function offsetUnset($offset): void {}

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
