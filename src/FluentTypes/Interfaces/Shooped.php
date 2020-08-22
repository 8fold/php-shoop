<?php

namespace Eightfold\Shoop\FluentTypes\Interfaces;

use \JsonSerializable;
use \Countable;

use Eightfold\Foldable\Foldable;

interface Shooped extends Foldable//, JsonSerializable, Countable //, PhpInterfaces, PhpMagicMethods
{
    public function __construct($main);
}
