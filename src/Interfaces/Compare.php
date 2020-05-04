<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Compare
{
    public function isGreaterThan($compare): ESBool;

    public function isGreaterThanOrEqual($compare): ESBool;

    public function isLessThan($compare): ESBool;

    public function isLessThanOrEqual($compare): ESBool;
}
