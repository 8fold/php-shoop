<?php

namespace Eightfold\Shoop\FilterContracts;

use Eightfold\Foldable\Foldable;

// use Eightfold\Shoop\FilterContracts\Interfaces\Addable;
use Eightfold\Shoop\FilterContracts\Interfaces\Arrayable;
use Eightfold\Shoop\FilterContracts\Interfaces\Associable;
use Eightfold\Shoop\FilterContracts\Interfaces\Comparable;
use Eightfold\Shoop\FilterContracts\Interfaces\Countable;
use Eightfold\Shoop\FilterContracts\Interfaces\Falsifiable;
use Eightfold\Shoop\FilterContracts\Interfaces\Reversible;
use Eightfold\Shoop\FilterContracts\Interfaces\Stringable;
// use Eightfold\Shoop\FilterContracts\Interfaces\Subtractable;
use Eightfold\Shoop\FilterContracts\Interfaces\Tupleable;
use Eightfold\Shoop\FilterContracts\Interfaces\Typeable;

interface Shooped extends
    Foldable,
    // Addable, part of Associable
    Arrayable,
    Comparable,
    Countable,
    Falsifiable,
    Reversible,
    Stringable,
    // Subtractable, part of Associable
    Tupleable,
    Typeable
{
    public function __construct($main);
}
