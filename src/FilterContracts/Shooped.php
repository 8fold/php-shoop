<?php

namespace Eightfold\Shoop\FilterContracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FilterContracts\Arrayable;
use Eightfold\Shoop\FilterContracts\Associable;
use Eightfold\Shoop\FilterContracts\Comparable;
use Eightfold\Shoop\FilterContracts\Countable;
use Eightfold\Shoop\FilterContracts\Falsifiable;
use Eightfold\Shoop\FilterContracts\Reversible;
use Eightfold\Shoop\FilterContracts\Stringable;
use Eightfold\Shoop\FilterContracts\Tupleable;
use Eightfold\Shoop\FilterContracts\Typeable;

interface Shooped extends
    Foldable,
    Arrayable,
    Comparable,
    Countable,
    Falsifiable,
    Reversible,
    Stringable,
    Tupleable,
    Typeable
{
    public function __construct($main);
}
