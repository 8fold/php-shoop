<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsNumber;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsNumber;
use Eightfold\Shoop\PipeFilters\TypeJuggling\IsInteger;

class FromInteger extends Filter
{
    /**
     * TODO: PHP 8.0 int|bool
     */
    public function __invoke($using): float
    {
        return (float) $using;
    }
}
