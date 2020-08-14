<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsDictionary extends Filter
{
    public function __invoke(array $payload): bool
    {
        if (count($payload) === 0) {
            // Empty array could become a dictionary; therefore, is true.
            return true;

        }
        // TODO: Consider using pipe for this.
        $members = array_keys($payload);
        $firstMember = $members[0];
        return is_string($firstMember) and ! is_int($firstMember);
    }
}
