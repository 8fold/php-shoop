<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Filter;

use Eightfold\Foldable\Filter;

use \stdClass;

use Eightfold\Shoop\Filter\TypesOf;

class TypeIsBoolean extends Filter
{
    public function __invoke($using): bool
    {
        return is_bool($using);
    }
}
