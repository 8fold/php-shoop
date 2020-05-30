<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Has
{
    public function has($needle, \Closure $closure = null);

    public function hasMember($member, \Closure $closure = null);
}
