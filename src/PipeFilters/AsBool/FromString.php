<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsBool;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class FromString extends Filter
{
    public function __invoke(string $payload): bool
    {
        return (bool) $payload;
    }
}
