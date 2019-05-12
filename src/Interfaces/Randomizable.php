<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESArray;

interface Randomizable
{
    public function random();

    public function shuffled(): ESArray;
}
