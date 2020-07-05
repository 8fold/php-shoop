<?php

namespace Eightfold\Shoop\Traits\ShoopedImpExtensions;

use \Closure;

use Eightfold\Shoop\Helpers\Type;

trait CompareImp
{
    public function is($compare, Closure $closure = null)
    {
        if (Type::isNotShooped($compare)) {
            $compare = Type::sanitizeType($compare, static::class);
        }
        $bool = $this->unfold() === $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isNot($compare, Closure $closure = null)
    {
        $bool = $this->is($compare)->toggle();
        return $this->condition($bool, $closure);
    }

    public function isEmpty(Closure $closure = null)
    {
        $bool = Type::isEmpty($this);
        return $this->condition($bool, $closure);
    }

    public function isNotEmpty(Closure $closure = null)
    {
        $bool = $this->isEmpty()->not();
        return $this->condition($bool, $closure);
    }

    public function isGreaterThan($compare, Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() > $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isGreaterThanOrEqual($compare, Closure $closure = null)
    {
        return $this->isGreaterThanOrEqualTo($compare, $closure);
    }

    public function isGreaterThanOrEqualTo($compare, Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() >= $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isLessThan($compare, Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() < $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isLessThanOrEqual($compare, Closure $closure = null)
    {
        return $this->isLessThanOrEqualTo($compare, $closure);
    }

    public function isLessThanOrEqualTo($compare, Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() <= $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function countIsGreaterThan($compare, \Closure $closure = null)
    {
        $bool = $this->count()->isGreaterThan($compare);
        return $this->condition($bool, $closure);
    }

    public function countIsGreaterThanOrEqualTo($compare, Closure $closure = null)
    {
        $bool = $this->count()->isGreaterThanOrEqualTo($compare);
        return $this->condition($bool, $closure);
    }

    public function countIsLessThan($compare, \Closure $closure = null)
    {
        $bool = $this->count()->isLessThan($compare);
        return $this->condition($bool, $closure);
    }

    public function countIsLessThanOrEqualTo($compare, \Closure $closure = null)
    {
        $bool = $this->count()->isLessThanOrEqualTo($compare);
        return $this->condition($bool, $closure);
    }
}
