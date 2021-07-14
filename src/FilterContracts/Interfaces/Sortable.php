<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

interface Sortable
{
    public function sort(int|callable $flag = SORT_REGULAR): Sortable;
}
