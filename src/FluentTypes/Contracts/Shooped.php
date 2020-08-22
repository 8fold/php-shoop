<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\Contracts\Typeable;
use Eightfold\Shoop\Contracts\Arrayable;

interface Shooped extends Foldable, Typeable, Arrayable
{
    public function __construct($main);
}
