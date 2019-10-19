<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Compare
{
    // Does not make sense on ESObject, ESDictionary, ESArray
    public function isGreaterThan($compare): ESBool;

    // Does not make sense on ESObject, ESDictionary, ESArray
    public function isGreaterThanOrEqual($compare): ESBool;

    // Does not make sense on ESObject, ESDictionary, ESArray
    public function isLessThan($compare): ESBool;

    // Does not make sense on ESObject, ESDictionary, ESArray
    public function isLessThanOrEqual($compare): ESBool;
}
