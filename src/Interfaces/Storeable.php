<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Storeable
{
    public function contains($needle): ESBool;
}
