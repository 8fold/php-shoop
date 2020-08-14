<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\AsObject;

use Eightfold\Foldable\Filter;

class FromDictionary extends Filter
{
    public function __invoke(array $payload): object
    {
        return (object) $payload;
    }
}
