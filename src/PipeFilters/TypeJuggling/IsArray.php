<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Members\FromList as MembersFromList;
use Eightfold\Shoop\PipeFilters\MinusUsing;
use Eightfold\Shoop\PipeFilters\IsNot;

use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromList as AsIntegerFromList;

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

        $members = MembersFromList::apply()->unfoldUsing($using);
        $count   = Shoop::pipe($members,
            MinusUsing::applyWith("is_int"),
            AsIntegerFromList::apply()
        )->unfold();

        $countsDoNotMatch = IsNot::applyWith(
                AsIntegerFromList::apply()->unfoldUsing($using)
            )->unfoldUsing($count);

        if ($countsMatch) {
            return false;
        }

        // Must be ordered.
        $start = $members[0];
        $end   = $members[$count - 1];
        $range = range($start, $end);

        return $members === $range;
    }
}
