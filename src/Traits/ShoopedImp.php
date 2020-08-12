<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\Php;
use Eightfold\Shoop\ESInt;

trait ShoopedImp
{
    use FoldableImp;//, CompareImp, PhpInterfacesImp;

    // TODO: PHP 8.0 - string|ESString
    public function __construct($main)
    {
        $this->main = $main;
    }
}
