<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\PipeFilters\Contracts\ArrayableImp;

use Eightfold\Shoop\FluentTypes\Contracts\ComparableImp;

trait ShoopedImp
{
    use FoldableImp, ArrayableImp, ComparableImp;//, CompareImp, PhpInterfacesImp;

    public function __construct($main)
    {
        $this->main = $main;
    }
}
