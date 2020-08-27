<?php

namespace Eightfold\Shoop\Filter\Contracts;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\Filter\Minus;
use Eightfold\Shoop\Filter\MinusAt;

trait SubtractableImp
{
    // TODO: PHP 8.0 bool|ESBoolean, bool|ESBoolean, string|ESString
    public function minus(
        array $charMask = [" ", "\t", "\n", "\r", "\0", "\x0B"],
        bool $fromStart = true,
        bool $fromEnd   = true
    )
    {
        return static::fold(
            Minus::applyWith($fromEnd, $fromStart, $charMask)
                ->unfoldUsing($this->main)
        );
    }
}
