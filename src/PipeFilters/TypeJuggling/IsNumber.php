<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

class IsNumber extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_int($using) and ! is_float($using)) {
            return false;

        }
        return true;
    }
}
