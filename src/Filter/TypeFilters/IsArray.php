<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\TypeFilters;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Members;
use Eightfold\Shoop\Filter\RetainUsing;
use Eightfold\Shoop\Filter\Count;
use Eightfold\Shoop\Filter\Is;
use Eightfold\Shoop\Filter\First;
use Eightfold\Shoop\Filter\Last;

class IsArray extends Filter
{
    public function __invoke($using): bool
    {
        if (! IsList::apply()->unfoldUsing($using)) {
            return false;
        }

        if (IsDictionary::apply()->unfoldUsing($using)) {
            return false;
        }

        $members       = Members::fromList($using);
        $stringMembers = RetainUsing::fromList($members, "is_int");
        $membersCount  = Count::fromList($stringMembers);
        if (Is::fromNumber($membersCount, 0)) {
            return false;
        }

        $firstIndex = First::fromList($members);
        if (! Is::fromNumber($firstIndex, 0)) {
            return false;
        }

        $lastIndex = Last::fromList($members);

        $range = AsRange::fromNumber($firstIndex, $lastIndex);

        return Is::fromList($members, $range);
    }
}
