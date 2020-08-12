<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpJson
};

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Contracts\Typeable;
use Eightfold\Shoop\Contracts\TypeableImp;

class ESJson implements Shooped, Typeable//, MathOperations, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp, TypeableImp;//, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;
}
