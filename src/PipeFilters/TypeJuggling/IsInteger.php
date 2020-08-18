<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsInteger extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_int($using) and ! is_float($using)) {
            return false;
        }

        $string      = strval($using);
        $pointPos    = strpos($string, ".");
        $pointExists = (bool) $pointPos;

        return ! $pointExists;
    }
}
