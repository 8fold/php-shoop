<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\Minus;
use Eightfold\Shoop\PipeFilters\MinusAt;

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

    public function minusAt(...$members)
    {
        return static::fold(
            MinusAt::applyWith(...$members)
                ->unfoldUsing($this->main)
        );
    }
}
