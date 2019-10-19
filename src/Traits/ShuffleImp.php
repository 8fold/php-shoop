<?php

namespace Eightfold\Shoop\Traits;

trait ShuffleImp
{
    public function shuffle()
    {
        $array = $this->array()->unfold();
        shuffle($array);
        return Shoop::array($array);
    }
}
