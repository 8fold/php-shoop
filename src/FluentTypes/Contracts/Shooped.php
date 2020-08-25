<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FluentTypes\Contracts\Comparable;

use Eightfold\Shoop\PipeFilters\Contracts\Arrayable;
use Eightfold\Shoop\PipeFilters\Contracts\Subtractable;
use Eightfold\Shoop\PipeFilters\Contracts\Countable;
use Eightfold\Shoop\PipeFilters\Contracts\Falsifiable;
use Eightfold\Shoop\PipeFilters\Contracts\Keyable;
use Eightfold\Shoop\PipeFilters\Contracts\Stringable;
use Eightfold\Shoop\PipeFilters\Contracts\Tupleable;
use Eightfold\Shoop\PipeFilters\Contracts\Typeable;

interface Shooped extends
    Foldable,
    Arrayable,
    Comparable,
    Subtractable,
    Countable,
    Falsifiable,
    Keyable,
    Stringable,
    Tupleable,
    Typeable
{
    public function __construct($main);

    // TODO: PHP 8.0 int|ESInteger -> Shooped|object|callable
    public function random($limit = 1);
}
