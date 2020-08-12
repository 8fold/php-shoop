<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpJson
};

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    MathOperations,
    Sort,
    Toggle,
    Wrap,
    Drop,
    Has,
    IsIn,
    Each
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    MathOperationsImp,
    SortImp,
    ToggleImp,
    WrapImp,
    DropImp,
    HasImp,
    IsInImp,
    EachImp
};

use Eightfold\Shoop\ESDictionary;

class ESJson implements Shooped//, MathOperations, Wrap, Drop, Has, IsIn, Each
{
    use ShoopedImp;//, ToggleImp, MathOperationsImp, SortImp, WrapImp, DropImp, HasImp, IsInImp, EachImp;
}
