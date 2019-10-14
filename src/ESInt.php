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

    public function array(): ESArray
    {
        // TODO: ?? allow user to set range bottom or top
        return Shoop::array(range(0, $this->value));
    }

    /**
     * @deprecated
     */
    public function enumerate(): ESArray
    {
        return $this->array();
    }

    public function int(): ESInt
    {
        return $this;
    }

    public function isGreaterThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESInt::class);
        $result = $this->unfold() > $compare->unfold();
        return Shoop::bool($result);
    }

    public function isGreaterThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESInt::class);
        $result = $this->unfold() >= $compare->unfold();
        return Shoop::bool($result);
    }

    public function isLessThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESInt::class);
        $result = $this->unfold() < $compare->unfold();
        return Shoop::bool($result);
    }

    public function isLessThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, ESInt::class);
        $result = $this->unfold() <= $compare->unfold();
        return Shoop::bool($result);
    }

    public function toggle(): ESInt
    {
        return $this->multiply(-1);
    }

    public function startsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->string();
        return $this->string()->startsWith($needle);
    }

    public function endsWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->string()->toggle();
        $reversed = $this->string()->toggle();
        return $reversed->startsWith($needle);
    }

    public function start(...$prefixes)
    {
        $prefixes = implode('', $prefixes);
        $cast = (int) $this->string()->start($prefixes)->unfold();
        return Shoop::int($cast);
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

    public function minus($value)
    {
        $term = Type::sanitizeType($value)->unfold();
        return ESInt::fold($this->unfold() - $term);
    }

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

    public function multiply($int)
    {
        $int = Type::sanitizeType($int, ESInt::class)->unfold();
        return ESInt::fold($this->unfold() * $int);
    }

























    public function append(...$args)
    {
        $intString = (string) $this->unfold();
        foreach ($terms as $term) {
            $term = (string) $this->sanitizeType($term, ESInt::class)->unfold();
            $intString .= $term;
        }
        $intInt = (integer) $intString;
        return Shoop::int($intInt);
    }

    public function prepend(...$args)
    {
        $intString = (string) $this->unfold();
        foreach ($terms as $term) {
            $term = (string) $this->sanitizeType($term, ESInt::class)->unfold();
            $intString = $term . $intString;
        }
        $intInt = (integer) $intString;
        return Shoop::int($intInt);
    }
}
