<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Helpers\Type;
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

    public function enumerate(): ESArray
    {
        return Shoop::array(range(0, $this->value));
    }

    public function plus(...$args)
    {
        $terms = $args;
        $terms = $args;
        $total = $this->value;
        foreach ($terms as $term) {
            $term = $this->sanitizeType($term, ESInt::class)->unfold();
            $total += $term;
        }

        return Shoop::int($total);
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

    public function minus($value)
    {
        $term = Type::sanitizeType($value)->unfold();
        return ESInt::fold($this->unfold() - $term);
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

    public function toggle(): ESInt
    {
        return $this->multiply(-1);
    }

    public function isGreaterThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        return Shoop::bool($this->unfold() > $compare);
    }

    public function isGreaterThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        return Shoop::bool($this->isGreaterThan($compare)->or($this->isSame($compare)));
    }

    public function isLessThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        return Shoop::bool($this->unfold() < $compare);
    }

    public function isLessThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare)->unfold();
        return Shoop::bool($this->isLessThan($compare)->or($this->isSame($compare)));
    }

    // TODO: verify used by something other tests
    public function isDivisible($value): ESBool
    {
        $divisor = $this->sanitizeType($value, ESInt::class);
        return Shoop::bool($this->unfold() % $divisor->unfold() == 0);
    }
}
