<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

class ESJson implements Shooped, Comparable //, MathOperations, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp, ComparableImp;//, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;
}
