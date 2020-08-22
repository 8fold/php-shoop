<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Typeable;
use Eightfold\Shoop\FluentTypes\Contracts\TypeableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Arrayable;
use Eightfold\Shoop\FluentTypes\Contracts\ArrayableImp;

class ESBoolean implements Shooped, Typeable, Comparable, Arrayable //, Toggle, IsIn
{
    use ShoopedImp, TypeableImp, ComparableImp, ArrayableImp;//, ToggleImp, IsInImp;
}
