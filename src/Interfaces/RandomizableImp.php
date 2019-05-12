<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESArray;

trait RandomizableImp
{
    public function random()
    {
        // TODO: Figure out return types
        $array = $this->array()->unwrap();
        $shuffled = $this->shuffled();
        $index = rand(0, count($shuffled->unwrap()) - 1);
        return $this->value[$index];
    }

    public function shuffled(): ESArray
    {
        $array = $this->array()->unwrap();
        shuffle($array);
        return ESArray::wrap($array);
    }
}
