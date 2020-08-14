<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBool;

use Eightfold\Foldable\Filter;

class FromInt extends Filter
{
    public function __invoke(int $payload): bool
    {
        return (bool) $payload;
    }
}
