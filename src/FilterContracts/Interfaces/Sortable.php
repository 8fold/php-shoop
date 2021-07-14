<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

interface Sortable
{
    // public function sort(int|callable $flag = SORT_REGULAR): Sortable;
    public function sort($flag = SORT_REGULAR): Sortable;
}
