<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\PipeFilters\Arrayable;
use Eightfold\Shoop\PipeFilters\Countable;
use Eightfold\Shoop\PipeFilters\Falsifiable;
use Eightfold\Shoop\PipeFilters\Keyable;
use Eightfold\Shoop\PipeFilters\Stringable;
use Eightfold\Shoop\PipeFilters\Tupleable;

interface Shooped extends
    Foldable,
    Arrayable,
    Countable,
    Falsifiable,
    Keyable,
    Stringable,
    Tupleable
{
    public function __construct($main);
}
