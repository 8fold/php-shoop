<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use \JsonSerializable;
use \Countable;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\FluentTypes\ESInteger;

interface Shooped extends Foldable//, JsonSerializable, Countable //, PhpInterfaces, PhpMagicMethods
{
    public function __construct($main);
}
