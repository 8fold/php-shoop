<?php
declare(strict_types=1);

namespace Eightfold\Shoop\Php;

use Eightfold\Foldable\Filter;

class MembersFromArray extends Filter
{
    public function __invoke(array $using): array
    {
        return array_keys($using);
    }
}
