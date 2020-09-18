<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter\Has;

use Eightfold\Foldable\Filter;

use Eightfold\Shoop\Filter\Members;
use Eightfold\Shoop\Filter\At;
use Eightfold\Shoop\Filter\Count;

use Eightfold\Shoop\Filter\Is\IsNotEmpty;

/**
 * @version 1.0.0
 */
class HasMethods extends Filter
{
    public function __invoke($using): bool
    {
        $members = Members::fromObject($using);
        $methods = At::fromDictionary($members, ["methods"]);
        return IsNotEmpty::fromNumber($methods);
    }
}
