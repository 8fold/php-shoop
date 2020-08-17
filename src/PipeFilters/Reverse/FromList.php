<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\Reverse;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class FromList extends Filter
{
    public function __invoke(array $using): array
    {
        return array_reverse($using);
    }
}
