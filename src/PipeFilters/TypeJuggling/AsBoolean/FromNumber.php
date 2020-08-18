<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsBoolean;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsInteger;

class FromNumber extends Filter
{
    /**
     * TODO: PHP 8.0 int|float
     */
    public function __invoke($using): bool
    {
        // TODO: Test these thoroughly, not getting consistent behavior
        // if (IsNumber::apply()->unfoldUsing($using) or
        //     IsInteger::apply()->unfoldUsing($using)
        // ) return false;

        return (bool) $using;
    }
}
