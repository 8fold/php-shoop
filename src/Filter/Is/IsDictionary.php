<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\Is;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Members;
use Eightfold\Shoop\Filter\RetainUsing;
use Eightfold\Shoop\Filter\Count;

/**
 * @todo deprecate - ??
 */
class IsDictionary extends Filter
{
    public function __invoke($using): bool
    {
        if (! IsList::apply()->unfoldUsing($using)) {
            return false;
        }

        $members       = Members::fromList($using);
        $stringMembers = RetainUsing::fromList($members, "is_string");
        $membersCount  = Count::fromList($stringMembers);
        if (IsIdenticalTo::fromNumber($membersCount, 0)) {
            return false;
        }

        $usingCount = Count::fromList($using);
        return IsIdenticalTo::fromNumber($usingCount, $membersCount);
    }
}
