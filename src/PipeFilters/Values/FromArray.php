<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\PullContent;

use Eightfold\Foldable\Filter;

class FromArray extends Filter
{
    public function __invoke(array $payload): array
    {
        return array_values($payload);
    }
}
