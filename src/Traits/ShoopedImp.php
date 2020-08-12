<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Foldable\FoldableImp;

use Eightfold\Shoop\Php;
use Eightfold\Shoop\ESInt;

trait ShoopedImp
{
    use FoldableImp;//, CompareImp, PhpInterfacesImp;

    // TODO: PHP 8.0 - string|ESString
    public function __construct($main)
    {
        $this->main = $main;
    }

// -> JsonSerializable
    public function jsonSerialize(): object
    {
        $type = gettype($this->main);
        $method = "{$type}ToObject";
        return Php::{$method}($this->main);
    }

// -> Countable
    public function int(): ESInt
    {
        return ESInt::fold($this->count());
    }

    public function count(): int
    {
        $type = gettype($this->main);
        $method = $type ."ToInt";
        return Php::{$method}($this->main);
    }
}
