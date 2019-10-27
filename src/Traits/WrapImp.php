<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\{
    Shoop,
    ESBool
};

use Eightfold\Shoop\Helpers\Type;

trait WrapImp
{
    public function first()
    {
        $array = $this->array()->unfold();
        $value = array_shift($array);
        if ($value === null) {
            return Shoop::array([]);
        }

        if (Type::isShooped($value)) {
            return $value;
        }
        return Type::sanitizeType($value);
    }

    public function last()
    {
        $v = $this->array()->unfold();
        $index = count($v) - 1;
        return $v[$index];
    }

    public function start(...$prefixes)
    {
        $prefixes = Type::sanitizeType($prefixes)->unfold();
        $merged = array_merge($prefixes, $this->unfold());
        return Shoop::array($merged);
    }

    public function end(...$suffixes) // 7.4 : self;
    {
        return $this->plus(...$suffixes);
    }

    public function doesNotStartWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->unfold();
        return $this->startsWith($needle)->toggle();
    }

    public function doesNotEndWith($needle): ESBool
    {
        $needle = Type::sanitizeType($needle)->unfold();
        return $this->endsWith($needle)->toggle();
    }
}
