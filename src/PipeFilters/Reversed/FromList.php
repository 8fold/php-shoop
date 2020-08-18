<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reversed;

use Eightfold\Foldable\Filter;

class FromList extends Filter
{
    public function __invoke(array $using): array
    {
        return array_reverse($using);
    }
}
