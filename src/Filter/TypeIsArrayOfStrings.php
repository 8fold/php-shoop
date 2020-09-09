<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Shoop;
use Eightfold\Shoop\Apply;

class TypeIsArrayOfStrings extends Filter
{
    public function __invoke($using): bool
    {
        return Shoop::pipe($using,
            Apply::typeAsArray(),
            Apply::allPass("is_string")
        )->unfold();
    }
}
