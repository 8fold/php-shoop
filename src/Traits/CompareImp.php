<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Helpers\Type;

use Eightfold\Shoop\{
    ESInt,
    ESBool
};

trait CompareImp
{
    public function isGreaterThan($compare, \Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() > $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isGreaterThanOrEqual($compare, \Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() >= $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isLessThan($compare, \Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() < $compare->unfold();
        return $this->condition($bool, $closure);
    }

    public function isLessThanOrEqual($compare, \Closure $closure = null)
    {
        $compare = Type::sanitizeType($compare, static::class);
        $bool = $this->unfold() <= $compare->unfold();
        return $this->condition($bool, $closure);
    }
}
