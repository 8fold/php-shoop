<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\{
    ESString,
    ESBool
};

use Eightfold\Shoop\Interfaces\{
    Wrappable,
    Equatable,
    EquatableImp
};

class ESArray implements Wrappable, Equatable
{
    use EquatableImp;

   private $value = [];

    static public function wrap(array $array): ESArray
    {
        return new ESArray($array);
    }

    // TODO: Convert atring to array
    static public function wrapString(string $string): ESString
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

//-> Randomizable
    public function random()
    {
        // TODO: Figure out return types
        $array = $this->array()->unwrap();
        $shuffled = $this->shuffled();
        $index = rand(0, count($shuffled->unwrap()) - 1);
        return $this->value[$index];
    }

    public function shuffled()
    {
        $array = $this->array()->unwrap();
        shuffle($array);
        return ESArray::wrap($array);
    }
}
