<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;

class IsArray extends Filter
{
    public function __invoke($using): bool
    {
        if (! is_array($using)) {
            return false;
        }

        // Shoop List but not enought data to differentiate.
        if ($using === array()) {
            return false;
        }

        $count      = count($using);
        $members    = array_keys($using);
        $intMembers = array_filter($members, "is_integer");

        if (count($intMembers) !== $count) {
            return false;
        }

        // Must be ordered.
        $start = $members[0];
        $end   = $members[$count - 1];
        $range = range($start, $end);

        return $members === $range;
    }
}
