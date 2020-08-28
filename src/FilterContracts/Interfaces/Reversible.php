<?php

namespace Eightfold\Shoop\FilterContracts\Interfaces;

interface Reversible
{
    public function reverse(): Reversible;
}
