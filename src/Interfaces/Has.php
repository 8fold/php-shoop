<?php

namespace Eightfold\Shoop\Interfaces;

use \Closure;

use Eightfold\Shoop\Interfaces\Foldable;
use Eightfold\Shoop\ESBool;

interface Has
{
    public function has($needle, Closure $closure = null);

    public function doesNothave($needle, Closure $closure = null);

    public function hasMember($member, Closure $closure = null);

    public function doesNotHaveMember($member, Closure $closure = null);
}
