<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Shoop;

trait ShuffleImp
{
    public function shuffle()
    {
        $array = $this->array()->unfold();
        shuffle($array);
        return Shoop::array($array);
    }
}
