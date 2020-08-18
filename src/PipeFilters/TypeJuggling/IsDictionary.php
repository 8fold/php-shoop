<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;

class IsDictionary extends Filter
{
    public function __invoke($using): bool
    {
        if (! IsList::apply()->unfoldUsing($using)) {
            return false;
        }

        // Shoop List but not enought data to differentiate.
        if ($using === array()) {
            return false;
        }

        // all members must be strings
        $keys = array_keys($using);
        $stringKeys = array_filter($keys, "is_string");

        return count($stringKeys) === count($using);
    }
}
