<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

class ESBoolean implements Shooped, Comparable //, Toggle, IsIn
{
    use ShoopedImp, ComparableImp;//, ToggleImp, IsInImp;
}
