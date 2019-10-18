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

use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Helpers\Type;


class ESInt implements Shooped, Countable, Toggle, Shuffle
{
    use ShoopedImp, CountableImp, ToggleImp, ShuffleImp, CompareImp;

    public function __construct($int)
    {
        if (is_int($int)) {
            $this->value = $int;

        } elseif (is_a($int, ESInt::class)) {
            $this->value = $int->unfold();

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

    public function int(): ESInt
    {
        return ESInt::fold($this->unfold());
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

// - Manipulate
    public function toggle($preserveMembers = true): ESInt
    {
        return $this->multiply(-1);
    }

    public function sort($caseSensitive = true): ESInt
    {
        $int = (int) $this->string()->sort($caseSensitive)->unfold();
        return ESInt::fold($int);
    }

    public function start(...$prefixes)
    {
        $prefixes = implode("", $prefixes);
        $cast = (int) $this->string()->start($prefixes)->unfold();
        return Shoop::int($cast);
    }

    public function end(...$suffixes)
    {
        $prefixes = implode("", $suffixes);
        $cast = (int) $this->string()->end($prefixes)->unfold();
        return Shoop::int($cast);
    }

    /**
     * @deprecated
     */
    public function append(...$args)
    {
        return $this->end(...$args);
    }

    /**
     * @deprecated
     */
    public function prepend(...$args)
    {
        return $this->start(...$args);
    }

// - Search
    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESInt::class)
            ->string()->unfold();
        return $this->string()->startsWith($needle);
    }

    public function endsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle, ESInt::class)
            ->string()->toggle()->unfold();
        $reversed = $this->string()->toggle();
        return $reversed->startsWith($needle);
    }

// - Math language
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

// - Getters
// - Comparison
// - Other
    public function range($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        if ($int > $this->unfold()) {
            return Shoop::this(range($this->unfold(), $int));
        }
        return Shoop::this(range($int, $this->unfold()));
    }
}
