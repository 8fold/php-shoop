<?php

namespace Eightfold\Shoop\FluentTypes\Traits;

use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\PipeFilters;
use Eightfold\Shoop\FluentTypes\ESInt;

trait ShoopedImp
{
    use FoldableImp;//, CompareImp, PhpInterfacesImp;

    // TODO: PHP 8.0 - string|ESString
    public function __construct($main)
    {
        $this->main = $main;
    }
}
