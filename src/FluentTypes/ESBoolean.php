<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;
use Eightfold\Shoop\FluentTypes\Traits\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Typeable;
use Eightfold\Shoop\FluentTypes\Contracts\TypeableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

class ESBoolean implements Shooped, Typeable, Comparable //, Toggle, IsIn
{
    use ShoopedImp, TypeableImp, ComparableImp;//, ToggleImp, IsInImp;
}
