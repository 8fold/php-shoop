<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\IsArray;

class IsDictionary extends Filter
{
    public function __invoke($using): bool
    {
        if (is_bool($using) or is_string($using)) return false;

        if (!is_array($using)) return false;

        $keys = array_keys($using);
        $stringKeys = array_filter($keys, "is_string");

        return count($stringKeys) > 0;
    }
}
