<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\IsNumber;

class FromNumber extends Filter
{
    // TODO: PHP 8.0 - int|float -> int|float
    public function __invoke($using)
    {
        // PHP 8.0 - remove
        if (! IsNumber::apply()->unfoldUsing($using)) {
            return 0;
        }
        return -$using;
    }
}
