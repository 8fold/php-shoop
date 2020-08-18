<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsBoolean extends Filter
{
    public function __invoke($using): bool
    {
        return is_bool($using);
    }
}
