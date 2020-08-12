<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Helpers\{
    Type,
    PhpBool
};

use Eightfold\Shoop\ESInt;

use Eightfold\Shoop\Interfaces\{
    Shooped,
    Typeable,
    Toggle,
    IsIn
};

use Eightfold\Shoop\Traits\{
    ShoopedImp,
    TypeableImp,
    ToggleImp,
    IsInImp
};

class ESBool implements Shooped, Typeable//, Toggle, IsIn
{
    use ShoopedImp, TypeableImp;//, ToggleImp, IsInImp;
}
