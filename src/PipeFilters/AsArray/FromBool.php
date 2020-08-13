<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsArray;

use Eightfold\Foldable\Filter;

class FromBool extends Filter
{
    public function __invoke(bool $payload): array
    {
        return [$payload];
    }
}
