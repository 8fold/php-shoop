<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Has
{
    // Does not make sense on ESBool
    // has($needle, \Closure $closure = null)
    public function has($needle): ESBool;

    // hasMember($member, \Closure $closure = null)
    public function hasMember($member): ESBool;
}
