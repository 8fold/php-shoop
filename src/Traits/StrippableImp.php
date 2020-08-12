<?php

namespace Eightfold\Shoop\Traits;

use Eightfold\Shoop\Php;

trait StrippableImp
{
    // TODO: PHP 8.0 bool|ESBool, bool|ESBool, string|ESString
    public function strip(
        $charMask  = " \t\n\r\0\x0B",
        $fromEnd   = true,
        $fromStart = true
    ): self
    {
        $type = gettype($this->main);
        $method = "{$type}StrippedOf";
        $string = Php::{$method}($this->main, $fromEnd, $fromStart, $charMask);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - Stringable
    public function stripTags(...$allow): self
    {
        $type = gettype($this->main);
        $method = "{$type}StrippedOfTags";
        $string = Php::{$method}($this->main, ...$allow);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - int|ESInt
    public function stripFirst($length = 1): self
    {
        $type = gettype($this->main);
        $method = "{$type}StrippedOfFirst";
        $string = Php::{$method}($this->main, $length);
        return static::fold($string);
    }

    // TODO: PHP 8.0 - int|ESInt
    public function stripLast($length = 1): self
    {
        $type = gettype($this->main);
        $method = "{$type}StrippedOfLast";
        $string = Php::{$method}($this->main, $length);
        return static::fold($string);
    }
}
