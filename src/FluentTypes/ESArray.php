<?php

namespace Eightfold\Shoop\FluentTypes;

use Eightfold\Shoop\FluentTypes\Contracts\Shooped;
use Eightfold\Shoop\FluentTypes\Contracts\ShoopedImp;

use Eightfold\Shoop\FluentTypes\Contracts\Addable;
use Eightfold\Shoop\FluentTypes\Contracts\AddableImp;

class ESArray implements Shooped, Addable
{
    use ShoopedImp, AddableImp;
}
