<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\Interfaces\Equatable;

interface Comparable
{
    public function isLessThan(Comparable $compare);

    public function isGreaterThan(Comparable $compare);
}
