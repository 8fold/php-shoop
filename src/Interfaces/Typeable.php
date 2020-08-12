<?php

namespace Eightfold\Shoop\Interfaces;

use \ArrayAccess;
use \Iterator;
use \Closure;
use \Countable;
use \JsonSerializable;

use Eightfold\Shoop\ESArray;
use Eightfold\Shoop\ESString;

interface Typeable extends Countable, JsonSerializable
{
    // public function array(): ESArray;

    public function string(): ESString;

    public function jsonSerialize(): object;
}
