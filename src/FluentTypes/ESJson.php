<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\FluentTypes\Helpers\{

    PhpJson
};

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\FluentTypes\Interfaces\Shooped;
use Eightfold\Shoop\FluentTypes\Traits\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Typeable;
use Eightfold\Shoop\FluentTypes\Contracts\TypeableImp;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;
use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

class ESJson implements Shooped, Typeable, Comparable //, MathOperations, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp, TypeableImp, ComparableImp;//, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;
}
