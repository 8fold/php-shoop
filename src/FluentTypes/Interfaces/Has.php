<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use \Closure;

use Eightfold\Shoop\Foldable\Foldable;
use Eightfold\Shoop\FluentTypes\ESBoolean;

interface Has
{
    public function has($needle, Closure $closure = null);

    public function doesNothave($needle, Closure $closure = null);

    public function hasMember($member, Closure $closure = null);

    public function doesNotHaveMember($member, Closure $closure = null);
}
