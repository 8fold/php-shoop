<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface IsIn
{
    public function isIn($haystack): ESBool;
}
