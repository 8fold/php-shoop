<?php

namespace Eightfold\Shoop\Interfaces;

use \ArrayAccess;
use \Iterator;
use \Closure;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESString;

interface Typeable
{
    // public function array(): ESArray;

    public function string(): ESString;
}
