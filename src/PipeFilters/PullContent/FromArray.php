<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\PullContent;

use Eightfold\Foldable\Filter;

// TODO: Remove
class FromArray extends Filter
{
    public function __invoke(array $using): array
    {
        return array_values($using);
    }
}
