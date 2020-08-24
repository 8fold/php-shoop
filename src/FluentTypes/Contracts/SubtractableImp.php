<?php

namespace Eightfold\Shoop\PipeFilters\Contracts;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\Contracts\SubtractableImp as PipeSubtractibleImp;

use Eightfold\Shoop\PipeFilters\Minus;
use Eightfold\Shoop\PipeFilters\MinusMembers;

trait SubtractableImp
{
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
}
