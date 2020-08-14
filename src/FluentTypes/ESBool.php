<?php

namespace Eightfold\Shoop;

use Eightfold\Shoop\Interfaces\Shooped;
use Eightfold\Shoop\Traits\ShoopedImp;

use Eightfold\Shoop\Contracts\Typeable;
use Eightfold\Shoop\Contracts\TypeableImp;

class ESBool implements Shooped, Typeable//, Toggle, IsIn
{
    use ShoopedImp, TypeableImp;//, ToggleImp, IsInImp;
}
