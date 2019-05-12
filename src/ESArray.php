<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESString,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable,
    Describable,
    Randomizable,
    EquatableImp,
    RandomizableImp
};

class ESArray implements Wrappable, Equatable, Describable, Randomizable
{
    use EquatableImp,
        RandomizableImp;

   private $value = [];

    static public function wrap(array $array): ESArray
    {
        return new ESArray($array);
    }

    // TODO: Convert atring to array
    static public function wrapString(string $string = "", int $count = 1): ESArray
    {
        return new ESArray([$string]);
    }

    public function __construct(array $array)
    {
        $this->value = $array;
    }

    public function unwrap(): array
    {
        return $this->value;
    }

    private function array(): ESArray
    {
        return ESArray::wrap($this->value);
    }

//-> Describable
    public function description(): ESString
    {
        $valuesAsString = implode(", ", $this->value);
        return ESString::wrapString("[{$valuesAsString}]");
    }
}
