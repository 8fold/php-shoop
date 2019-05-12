<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\ESBool;

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable,
    EquatableImp
};

class ESArray implements Wrappable, Equatable
{
    use EquatableImp;

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
}
