<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\Contracts\TypeableImp;
use Eightfold\Shoop\Contracts\ArrayableImp;

trait ShoopedImp
{
    use FoldableImp, TypeableImp, ArrayableImp;//, CompareImp, PhpInterfacesImp;

    public function __construct($main)
    {
        $this->main = $main;
    }
}
