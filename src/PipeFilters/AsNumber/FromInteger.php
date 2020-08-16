<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsNumber;

use Eightfold\Foldable\Filter;
use Eightfold\Shoop\PipeFilters\IsNumber;
use Eightfold\Shoop\PipeFilters\IsInteger;

class FromInteger extends Filter
{
    /**
     * TODO: PHP 8.0 int|bool
     */
    public function __invoke($using): float
    {
        // TODO: Test these thoroughly, not getting consistent behavior
        // if (IsNumber::apply()->unfoldUsing($using) or
        //     IsInteger::apply()->unfoldUsing($using)
        // ) return false;

        return (float) $using;
    }
}
