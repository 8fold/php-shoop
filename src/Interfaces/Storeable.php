<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Storeable
{
    public function isEmpty(): ESBool;

    public function contains($needle): ESBool;
}
