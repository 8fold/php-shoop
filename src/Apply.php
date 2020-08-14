<?php

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Apply as BaseApply;

class Apply extends BaseApply
{
    static public function rootNameSpaceForFilters()
    {
        return __NAMESPACE__ ."\\PipeFilters";
    }
}
