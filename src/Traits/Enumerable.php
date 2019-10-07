<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESInt
};

trait Enumerable
{
    abstract public function enumerate(): ESArray;

    public function count()
    {
        return Shoop::int(count($this->enumerate()->unfold()));
    }

    public function countIsGreaterThan($value)
    {
        $value = $this->sanitizeType($value, ESInt::class)
            ->unfold();
        return $this->count()->isGreaterthan($value);
    }

    public function countIsNotGreaterThan($value)
    {
        $value = $this->sanitizeType($value, ESInt::class)->unfold();
        return $this->count()->isNotGreaterThan($value);
    }

    public function countIsLessThan($value)
    {
        $value = $this->sanitizeType($value, ESInt::class)->unfold();
        return $this->count()->isLessThan($value);
    }

    public function countIsNotLessThan($value)
    {
        $value = $this->sanitizeType($value, ESInt::class)->unfold();
        return $this->count()->isNotLessThan($value);
    }
}
