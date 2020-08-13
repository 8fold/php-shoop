<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsInt;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

use Eightfold\Shoop\PipeFilters\AsArray;
use Eightfold\Shoop\PipeFilters\AsInt;

class FromString extends Filter
{
    public function __invoke(string $payload): int
    {
        return Shoop::pipe($payload, AsArray::apply(), First::apply())->unfold();
    }
}
