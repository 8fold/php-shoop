<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\FoldableImp;

trait ShoopedImp
{
    use FoldableImp;//, CompareImp, PhpInterfacesImp;

    public function __construct($main)
    {
        $this->main = $main;
    }
}
