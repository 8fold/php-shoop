<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\IsEmpty;

use Eightfold\Foldable\Filter;

class FromArray extends Filter
{
    public function __invoke(array $using): bool
    {
        return empty($using);
    }
}
