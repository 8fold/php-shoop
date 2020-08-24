<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\Minus;
use Eightfold\Shoop\PipeFilters\MinusMembers;

trait SubtractableImp
{
    // TODO: PHP 8.0 bool|ESBoolean, bool|ESBoolean, string|ESString
    public function minus(
        $charMask  = " \t\n\r\0\x0B",
        $fromEnd   = true,
        $fromStart = true
    ): self
    {
        return static::fold(
            Minus::applyWith($fromEnd, $fromStart, $charMask)
                ->unfoldUsing($this->main)
        );
    }

    public function minusMembers(...$members)
    {
        return static::fold(
            MinusMembers::applyWith(...$members)
                ->unfoldUsing($this->main)
        );
    }

    public function minusEmpties()
    {
        return static::fold(
            MinusUsing::applyWith("is_empty")->unfoldUsing($this->main)
        );
    }

    public function minusFirst($length = 1)
    {
        return static::fold(
            MinusFirst::applyWith($length)->unfoldUsing($this->main)
        );
    }

    public function minusLast($length = 1)
    {
        // TODO: Accept and respond to Subtractable
        return static::fold(
            MinusLast::applyWith($length)->unfoldUsing($this->main)
        );
    }

    /**
     * @deprecated
     */
    public function drop(...$members)
    {
        return $this->minusMembers(...$members);
    }

    /**
     * @deprecated
     */
    public function dropFirst($length = 1)
    {
        return $this->minusFirst($length);
    }

    /**
     * @deprecated
     */
    public function dropLast($length = 1)
    {
        return $this->minusLast($length);
    }
}
