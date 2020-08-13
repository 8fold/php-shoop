<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsDictionary;

use Eightfold\Foldable\Filter;

class FromObject extends Filter
{
    public function __invoke(object $payload): array
    {
        return (array) $payload;
    }
}
