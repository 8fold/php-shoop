<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESString;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Interfaces\Shooped;

class ESInt implements Shooped
{
    use ShoopedImp;

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
