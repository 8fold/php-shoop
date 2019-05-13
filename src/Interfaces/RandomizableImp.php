<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESArray;

trait RandomizableImp
{
    public function random()
    {
        // TODO: Figure out return types
        if ($this->isEmpty()->unwrap()) {
            return;
        }
        $shuffled = $this->shuffled()->unwrap();
        $index = rand(0, count($shuffled) - 1);
        return $shuffled[$index];
    }

    public function shuffled(): ESArray
    {
        $array = $this->array()->unwrap();
        shuffle($array);
        return ESArray::wrap($array);
    }
}
