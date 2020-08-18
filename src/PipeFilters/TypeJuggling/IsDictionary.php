<?php
declare(strict_types=1);

namespace Eightfold\Shoop\PipeFilters\TypeJuggling;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\PipeFilters\Members\FromList as MembersFromList;
use Eightfold\Shoop\PipeFilters\MinusUsing;
use Eightfold\Shoop\PipeFilters\Is;

use Eightfold\Shoop\PipeFilters\TypeJuggling\IsList;
use Eightfold\Shoop\PipeFilters\TypeJuggling\AsInteger\FromList as AsIntegerFromList;

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
        return Shoop::pipe($using,
            MembersFromList::apply(),
            MinusUsing::applyWith("is_string"),
            AsIntegerFromList::apply(),
            Is::applyWith(
                AsIntegerFromList::apply()->unfoldUsing($using)
            )
        )->unfold();
    }
}
