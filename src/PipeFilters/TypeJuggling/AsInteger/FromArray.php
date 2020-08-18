<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger;

use Eightfold\Foldable\Filter;

class FromArray extends Filter
{
    public function __invoke(array $using): int
    {
        return count($using);
    }
}
