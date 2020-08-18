<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsInteger;

class FromNumber extends Filter
{
    /**
     * TODO: PHP 8.0 int|float
     */
    public function __invoke($using): int
    {
        return (int) $using;
    }
}
