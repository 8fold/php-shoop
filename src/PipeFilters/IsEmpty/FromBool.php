<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\IsEmpty;

use Eightfold\Foldable\Filter;

class FromBool extends Filter
{
    public function __invoke(bool $using): bool
    {
        return empty($using);
    }
}
