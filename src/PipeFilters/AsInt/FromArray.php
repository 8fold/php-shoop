<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInt;

use Eightfold\Foldable\Filter;

class FromArray extends Filter
{
    public function __invoke(array $payload): int
    {
        return count($payload);
    }
}
