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
    public function isGreaterThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, static::class);
        $result = $this->unfold() > $compare->unfold();
        return Shoop::bool($result);
    }

    public function isGreaterThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, static::class)->unfold();
        $result = $this->unfold() >= $compare;
        return Shoop::bool($result);
    }

    public function isLessThan($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, static::class)->unfold();
        $result = $this->unfold() < $compare;
        return Shoop::bool($result);
    }

    public function isLessThanOrEqual($compare): ESBool
    {
        $compare = Type::sanitizeType($compare, static::class)->unfold();
        $result = $this->unfold() <= $compare;
        return Shoop::bool($result);
    }
}
