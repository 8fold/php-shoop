<?php

namespace Eightfold\Shoop\FluentTypes\Contracts;

use Eightfold\Foldable\Foldable;

interface Shooped extends Foldable//, JsonSerializable, Countable //, PhpInterfaces, PhpMagicMethods
{
    public function __construct($main);
}
