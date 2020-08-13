<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsArray;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\AsObject;
use Eightfold\Shoop\PipeFilters\AsArray;

class FromJson extends Filter
{
    public function __invoke(string $payload): array
    {
        return Shoop::pipe($payload,
            AsObject::apply(),
            AsArray::apply()
        )->unfold();
    }
}
