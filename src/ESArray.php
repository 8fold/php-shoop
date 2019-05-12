<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable
};

class ESArray implements Wrappable, Equatable
{
    private $value = [];

    static public function wrap(array $array)
    {
        return new ESArray($array);
    }

    public function __construct(array $array)
    {
        $this->value = $array;
    }

    public function unwrap(): array
    {
        return $this->value;
    }

//-> Equatable
    public function isSameAs(Equatable $compare): ESBool
    {
        return ESBool::init($this->value === $compare->unwrap());
    }

    public function isDifferentThan(Equatable $compare): ESBool
    {
        return $this->isSameAs($compare)->toggle();
    }
}
