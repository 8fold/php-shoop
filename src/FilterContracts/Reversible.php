<?php

namespace Eightfold\Shoop\FilterContracts;

interface Reversible
{
    public function reverse(): Reversible;
}
