<?php

namespace Eightfold\Shoop\Interfaces;

use Eightfold\Shoop\ESBool;

interface Equatable
{
    public function isSameAs(Equatable $compare): ESBool;

    public function isDifferentThan(Equatable $compare): ESBool;
}
