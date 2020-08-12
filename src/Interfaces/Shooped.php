<?php

namespace Eightfold\Shoop\Interfaces;

use \JsonSerializable;
use \Countable;

use Eightfold\Foldable\Foldable;

use Eightfold\Shoop\ESInt;

interface Shooped extends Foldable//, JsonSerializable, Countable //, PhpInterfaces, PhpMagicMethods
{
    public function __construct($main);
}
