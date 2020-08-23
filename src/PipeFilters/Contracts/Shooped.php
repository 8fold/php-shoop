<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\PipeFilters\Contracts\Arrayable;
use Eightfold\Shoop\PipeFilters\Contracts\Comparable;
use Eightfold\Shoop\PipeFilters\Contracts\Countable;
use Eightfold\Shoop\PipeFilters\Contracts\Falsifiable;
use Eightfold\Shoop\PipeFilters\Contracts\Keyable;
use Eightfold\Shoop\PipeFilters\Contracts\Reversible;
use Eightfold\Shoop\PipeFilters\Contracts\Stringable;
use Eightfold\Shoop\PipeFilters\Contracts\Tupleable;

interface Shooped extends
    Foldable,
    Arrayable,
    Comparable,
    Countable,
    Falsifiable,
    Keyable,
    Stringable,
    Tupleable
{
    public function __construct($main);
}
